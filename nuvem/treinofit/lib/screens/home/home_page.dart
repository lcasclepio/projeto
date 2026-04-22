import 'package:flutter/material.dart';
import 'package:treinofit/core/theme/app_theme.dart';
import '../treino/lista_treinos_page.dart';
import '../perfil/perfil_page.dart';
import 'package:shared_preferences/shared_preferences.dart';
import 'dart:io';

class HomePage extends StatefulWidget {
  final Map<String, dynamic> aluno;

  const HomePage({
    super.key,
    required this.aluno,
  });

  @override
  State<HomePage> createState() => _HomePageState();
}

class _HomePageState extends State<HomePage> {
  File? _imagemPerfil;

  @override
  void initState() {
    super.initState();
    _carregarImagemSalva();
  }

  Future<void> _carregarImagemSalva() async {
    final prefs = await SharedPreferences.getInstance();
    final path = prefs.getString('foto_perfil');
    if (path != null && File(path).existsSync()) {
      setState(() {
        _imagemPerfil = File(path);
      });
    }
  }

  @override
  Widget build(BuildContext context) {
    final fotoUrl = widget.aluno['fotoUrl']?.toString();

    ImageProvider? provider;

    if (_imagemPerfil != null) {
      provider = FileImage(_imagemPerfil!);
    } else if (fotoUrl != null && fotoUrl.isNotEmpty) {
      provider = NetworkImage(fotoUrl);
    }

    return Scaffold(
      appBar: AppBar(
        title: Text(
          "Bem-vindo, ${widget.aluno['nome']?.split(' ').first}!",
        ),
        actions: [
          IconButton(
            icon: const Icon(Icons.refresh, size: 22),
            tooltip: 'Atualizar',
            onPressed: () {
              _carregarImagemSalva();
            },
          ),
          Container(
            margin: const EdgeInsets.only(right: 8),
            decoration: BoxDecoration(
              shape: BoxShape.circle,
              border: Border.all(
                color: AppTheme.primaryColor,
                width: 2,
              ),
            ),
            child: IconButton(
              icon: const Icon(Icons.exit_to_app),
              tooltip: 'Sair',
              onPressed: () =>
                  Navigator.pushReplacementNamed(context, '/'),
            ),
          ),
        ],
      ),
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
        child: SingleChildScrollView(
          padding: const EdgeInsets.all(20),
          child: Column(
            crossAxisAlignment: CrossAxisAlignment.center,
            children: [
              Center(
                child: CircleAvatar(
                  radius: 48,
                  backgroundColor:
                      AppTheme.primaryColor.withAlpha(80),
                  backgroundImage: provider,
                  child: provider == null
                      ? Icon(
                          Icons.person,
                          size: 48,
                          color: AppTheme.primaryColor,
                        )
                      : null,
                ),
              ),
              const SizedBox(height: 60),
              Text(
                'Minhas Atividades',
                style: Theme.of(context)
                    .textTheme
                    .headlineSmall,
                textAlign: TextAlign.center,
              ),
              const SizedBox(height: 40),
              _buildActionCard(
                context: context,
                icon: Icons.fitness_center,
                title: 'Meus Treinos',
                subtitle:
                    'Visualize e gerencie seus treinos',
                color: AppTheme.primaryColor,
                onTap: () {
                  Navigator.push(
                    context,
                    MaterialPageRoute(
                      builder: (_) => ListaTreinosPage(
                        alunoId: int.parse(
                          widget.aluno['id']
                              .toString(),
                        ),
                      ),
                    ),
                  );
                },
              ),
              const SizedBox(height: 24),
              _buildActionCard(
                context: context,
                icon: Icons.person,
                title: 'Meu Perfil',
                subtitle:
                    'Veja suas informações pessoais',
                color: AppTheme.accentColor,
                onTap: () {
                  Navigator.push(
                    context,
                    MaterialPageRoute(
                      builder: (_) =>
                          PerfilPage(
                            aluno: widget.aluno,
                          ),
                    ),
                  ).then((_) =>
                      _carregarImagemSalva());
                },
              ),
            ],
          ),
        ),
      ),
    );
  }

  Widget _buildActionCard({
    required BuildContext context,
    required IconData icon,
    required String title,
    required String subtitle,
    required Color color,
    required VoidCallback onTap,
  }) {
    return InkWell(
      borderRadius:
          BorderRadius.circular(16),
      onTap: onTap,
      child: Container(
        padding:
            const EdgeInsets.all(16),
        decoration: BoxDecoration(
          color: AppTheme.cardBackground
              .withAlpha(200),
          borderRadius:
              BorderRadius.circular(16),
          border: Border.all(
            color: color.withAlpha(150),
            width: 2,
          ),
        ),
        child: Row(
          children: [
            Container(
              padding:
                  const EdgeInsets.all(12),
              decoration:
                  BoxDecoration(
                color:
                    color.withAlpha(200),
                borderRadius:
                    BorderRadius.circular(
                        12),
              ),
              child: Icon(
                icon,
                color: Colors.white,
              ),
            ),
            const SizedBox(width: 16),
            Expanded(
              child: Column(
                crossAxisAlignment:
                    CrossAxisAlignment
                        .start,
                children: [
                  Text(title),
                  Text(subtitle),
                ],
              ),
            ),
            Icon(
              Icons.arrow_forward_ios,
              color: color,
              size: 18,
            ),
          ],
        ),
      ),
    );
  }
}
