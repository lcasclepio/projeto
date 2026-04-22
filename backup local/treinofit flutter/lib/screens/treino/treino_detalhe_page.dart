import 'dart:async';
import 'package:flutter/material.dart';
import 'package:treinofit/core/services/api_service.dart';
import 'package:treinofit/core/theme/app_theme.dart';

class TreinoDetalhePage extends StatefulWidget {
  final int treinoId;
  const TreinoDetalhePage({super.key, required this.treinoId});

  @override
  State<TreinoDetalhePage> createState() => _TreinoDetalhePageState();
}

class _TreinoDetalhePageState extends State<TreinoDetalhePage> {
  late Map<int, ValueNotifier<int>> exercicioSegundos = {};
  late Map<int, Timer> exercicioTimers = {};

  String _formatTime(int s) {
    final m = (s ~/ 60).toString().padLeft(2, '0');
    final sec = (s % 60).toString().padLeft(2, '0');
    return "$m:$sec";
  }

  void toggleTimer(int index) {
    if (exercicioTimers[index]?.isActive ?? false) {
      exercicioTimers[index]?.cancel();
      exercicioTimers.remove(index);
    } else {
      exercicioTimers[index] = Timer.periodic(const Duration(seconds: 1), (t) {
        exercicioSegundos[index]?.value++;
      });
    }
  }

  void resetTimer(int index) {
    exercicioTimers[index]?.cancel();
    exercicioTimers.remove(index);
    exercicioSegundos[index]?.value = 0;
  }

  @override
  void dispose() {
    for (var timer in exercicioTimers.values) {
      timer.cancel();
    }
    for (var notifier in exercicioSegundos.values) {
      notifier.dispose();
    }
    super.dispose();
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(title: const Text("Detalhes do Treino")),
      body: Container(
        decoration: BoxDecoration(
          gradient: LinearGradient(
            begin: Alignment.topCenter,
            end: Alignment.bottomCenter,
            colors: [
              AppTheme.darkBackground,
              AppTheme.cardBackground.withAlpha(180),
            ],
          ),
        ),
        child: FutureBuilder<Map<String, dynamic>>(
          future: ApiService.post(
            "treino/ver_treino.php",
            {"treino_id": widget.treinoId.toString()},
          ),
          builder: (context, snap) {
            if (snap.connectionState == ConnectionState.waiting) {
              return const Center(
                child: CircularProgressIndicator(
                  valueColor: AlwaysStoppedAnimation<Color>(
                    AppTheme.primaryColor,
                  ),
                ),
              );
            }

            if (!snap.hasData || snap.data!['success'] != true) {
              return Center(
                child: Column(
                  mainAxisAlignment: MainAxisAlignment.center,
                  children: [
                    Icon(
                      Icons.error_outline,
                      size: 64,
                      color: AppTheme.primaryColor.withAlpha(100),
                    ),
                    const SizedBox(height: 16),
                    const Text(
                      "Erro ao carregar detalhes",
                      style: TextStyle(
                        color: AppTheme.textSecondary,
                        fontSize: 16,
                      ),
                    ),
                  ],
                ),
              );
            }

            final dados = snap.data!['data'];
            final exercicios = dados['exercicios'] as List;

            return Column(
              children: [
                // Observação geral (vinda do backend)
                if ((dados['observacao_geral'] ?? '').toString().trim().isNotEmpty)
                  Container(
                    width: double.infinity,
                    padding: const EdgeInsets.all(12),
                    margin: const EdgeInsets.symmetric(horizontal: 16, vertical: 8),
                    decoration: BoxDecoration(
                      color: AppTheme.cardBackground.withAlpha(200),
                      borderRadius: BorderRadius.circular(12),
                      border: Border.all(
                        color: AppTheme.primaryColor.withAlpha(80),
                        width: 1,
                      ),
                    ),
                    child: Column(
                      crossAxisAlignment: CrossAxisAlignment.start,
                      children: [
                        Text(
                          'Observação Geral',
                          style: Theme.of(context).textTheme.labelSmall?.copyWith(
                                color: AppTheme.textPrimary,
                                fontWeight: FontWeight.bold,
                              ),
                        ),
                        const SizedBox(height: 8),
                        Text(
                          dados['observacao_geral']?.toString() ?? '',
                          style: const TextStyle(
                            color: AppTheme.textSecondary,
                            fontSize: 14,
                          ),
                        ),
                      ],
                    ),
                  ),

                // LISTA DE EXERCÍCIOS
                Expanded(
                  child: exercicios.isEmpty
                      ? Center(
                          child: Column(
                            mainAxisAlignment: MainAxisAlignment.center,
                            children: [
                              Icon(
                                Icons.fitness_center,
                                size: 64,
                                color: AppTheme.primaryColor.withAlpha(100),
                              ),
                              const SizedBox(height: 16),
                              const Text(
                                "Nenhum exercício neste treino",
                                style: TextStyle(
                                  color: AppTheme.textSecondary,
                                ),
                              ),
                            ],
                          ),
                        )
                      : ListView.builder(
                          padding: const EdgeInsets.symmetric(horizontal: 16),
                          itemCount: exercicios.length,
                          itemBuilder: (_, i) {
                            final ex = exercicios[i];
                            final comentario = ex['comentario']?.toString() ?? '';
                            
                            // Inicializa ValueNotifier para este exercício
                            exercicioSegundos.putIfAbsent(i, () => ValueNotifier(0));
                            
                            return ValueListenableBuilder<int>(
                              valueListenable: exercicioSegundos[i]!,
                              builder: (context, segundos, _) {
                                final isExecutando = exercicioTimers[i]?.isActive ?? false;
                                
                                return Container(
                                  margin: const EdgeInsets.only(bottom: 12),
                                  decoration: BoxDecoration(
                                    color: AppTheme.cardBackground.withAlpha(200),
                                    borderRadius: BorderRadius.circular(16),
                                    border: Border.all(
                                      color: AppTheme.primaryColor.withAlpha(100),
                                      width: 1,
                                    ),
                                    boxShadow: [
                                      BoxShadow(
                                        color: Colors.black.withAlpha(100),
                                        blurRadius: 8,
                                        spreadRadius: 1,
                                      ),
                                    ],
                                  ),
                                  child: Padding(
                                    padding: const EdgeInsets.all(16),
                                    child: Column(
                                      crossAxisAlignment: CrossAxisAlignment.start,
                                      children: [
                                        Row(
                                          children: [
                                            Container(
                                              padding: const EdgeInsets.all(8),
                                              decoration: BoxDecoration(
                                                color: AppTheme.primaryColor.withAlpha(200),
                                                borderRadius: BorderRadius.circular(8),
                                              ),
                                              child: const Icon(
                                                Icons.fitness_center,
                                                color: Colors.white,
                                                size: 20,
                                              ),
                                            ),
                                            const SizedBox(width: 12),
                                            Expanded(
                                              child: Text(
                                                ex['nome'] ?? 'Sem nome',
                                                style: const TextStyle(
                                                  color: AppTheme.textPrimary,
                                                  fontSize: 16,
                                                  fontWeight: FontWeight.bold,
                                                ),
                                              ),
                                            ),
                                          ],
                                        ),
                                        const SizedBox(height: 12),
                                        // comentário do exercício, se existir
                                        if (comentario.isNotEmpty)
                                          Padding(
                                            padding: const EdgeInsets.only(bottom: 12),
                                            child: Text(
                                              comentario,
                                              style: const TextStyle(
                                                color: AppTheme.textSecondary,
                                                fontSize: 13,
                                              ),
                                            ),
                                          ),
                                        // Cronômetro do exercício
                                        Container(
                                          padding: const EdgeInsets.all(12),
                                          decoration: BoxDecoration(
                                            color: AppTheme.primaryColor.withAlpha(100),
                                            borderRadius: BorderRadius.circular(8),
                                          ),
                                          child: Column(
                                            children: [
                                              Text(
                                                _formatTime(segundos),
                                                style: const TextStyle(
                                                  fontSize: 24,
                                                  fontWeight: FontWeight.bold,
                                                  color: Colors.white,
                                                  fontFamily: 'monospace',
                                                ),
                                              ),
                                              const SizedBox(height: 8),
                                              Row(
                                                mainAxisAlignment: MainAxisAlignment.center,
                                                children: [
                                                  Expanded(
                                                    child: ElevatedButton.icon(
                                                      onPressed: () => toggleTimer(i),
                                                      style: ElevatedButton.styleFrom(
                                                        backgroundColor: Colors.white,
                                                        foregroundColor: AppTheme.primaryColor,
                                                      ),
                                                      icon: Icon(
                                                        isExecutando ? Icons.pause : Icons.play_arrow,
                                                      ),
                                                      label: Text(
                                                        isExecutando ? "Pausar" : "Iniciar",
                                                        style: const TextStyle(
                                                          fontWeight: FontWeight.bold,
                                                        ),
                                                      ),
                                                    ),
                                                  ),
                                                  const SizedBox(width: 8),
                                                  Expanded(
                                                    child: OutlinedButton.icon(
                                                      onPressed: () => resetTimer(i),
                                                      style: OutlinedButton.styleFrom(
                                                        side: const BorderSide(
                                                          color: Colors.white,
                                                          width: 2,
                                                        ),
                                                        foregroundColor: Colors.white,
                                                      ),
                                                      icon: const Icon(Icons.refresh),
                                                      label: const Text("Resetar"),
                                                    ),
                                                  ),
                                                ],
                                              ),
                                            ],
                                          ),
                                        ),
                                      ],
                                    ),
                                  ),
                                );
                              },
                            );
                          },
                        ),
                ),
              ],
            );
          },
        ),
      ),
    );
  }

}