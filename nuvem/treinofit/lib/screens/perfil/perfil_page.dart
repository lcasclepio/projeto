import 'package:flutter/material.dart';
import 'package:treinofit/core/theme/app_theme.dart';
import 'package:image_picker/image_picker.dart';
import 'package:shared_preferences/shared_preferences.dart';
import 'dart:io';

class PerfilPage extends StatefulWidget {
  final Map<String, dynamic> aluno;

  const PerfilPage({
    super.key,
    required this.aluno,
  });

  @override
  State<PerfilPage> createState() => _PerfilPageState();
}

class _PerfilPageState extends State<PerfilPage> {
  File? _imagemPerfil;
  final ImagePicker _picker = ImagePicker();

  @override
  void initState() {
    super.initState();
    _carregarImagemSalva();
  }

  Future<void> _selecionarImagem() async {
    final XFile? pickedFile =
    await _picker.pickImage(source: ImageSource.gallery);

    if (pickedFile != null) {
      final prefs = await SharedPreferences.getInstance();
      await prefs.setString('foto_perfil', pickedFile.path);

      setState(() {
        _imagemPerfil = File(pickedFile.path);
      });
    }
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
    return Scaffold(
      appBar: AppBar(
        title: const Text('Meu Perfil'),
        centerTitle: true,
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
            children: [
              GestureDetector(
                onTap: _selecionarImagem,
                child: Container(
                  width: 120,
                  height: 120,
                  decoration: BoxDecoration(
                    shape: BoxShape.circle,
                    gradient: LinearGradient(
                      colors: [
                        AppTheme.primaryColor,
                        AppTheme.primaryColor.withAlpha(180),
                      ],
                    ),
                    boxShadow: [
                      BoxShadow(
                        color: AppTheme.primaryColor.withAlpha(100),
                        blurRadius: 20,
                        spreadRadius: 5,
                      ),
                    ],
                  ),
                  child: ClipOval(
                    child: _imagemPerfil != null
                        ? Image.file(
                      _imagemPerfil!,
                      width: 120,
                      height: 120,
                      fit: BoxFit.cover,
                    )
                        : (widget.aluno['fotoUrl'] != null &&
                        widget.aluno['fotoUrl']
                            .toString()
                            .isNotEmpty
                        ? Image.network(
                      widget.aluno['fotoUrl'],
                      width: 120,
                      height: 120,
                      fit: BoxFit.cover,
                    )
                        : Icon(
                      Icons.person,
                      color: AppTheme.textPrimary,
                      size: 60,
                    )),
                  ),
                ),
              ),
              const SizedBox(height: 8),
              Text(
                'Toque para alterar a foto',
                style: TextStyle(
                  color: AppTheme.textSecondary,
                  fontSize: 12,
                ),
              ),
              const SizedBox(height: 20),

              Text(
                widget.aluno['nome']?.toString() ?? 'N/A',
                style: Theme.of(context).textTheme.displaySmall,
                textAlign: TextAlign.center,
              ),

              const SizedBox(height: 24),

              _buildInfoCard(
                context,
                icon: Icons.email_outlined,
                label: 'E-mail',
                value: widget.aluno['email']?.toString() ?? 'N/A',
                color: AppTheme.primaryColor,
              ),

              const SizedBox(height: 12),

              _buildInfoCard(
                context,
                icon: Icons.badge_outlined,
                label: 'CPF',
                value: widget.aluno['cpf']?.toString() ?? 'N/A',
                color: AppTheme.primaryColor,
              ),

              const SizedBox(height: 12),

              _buildInfoCard(
                context,
                icon: Icons.fitness_center,
                label: 'Plano',
                value: widget.aluno['plano']?.toString() ?? 'N/A',
                color: AppTheme.primaryColor,
              ),

              const SizedBox(height: 12),

              _buildInfoCard(
                context,
                icon: Icons.payment_outlined,
                label: 'Mensalidade',
                value:
                'R\$ ${widget.aluno['mensalidade']?.toString() ?? 'N/A'}',
                color: AppTheme.accentColor,
              ),

              const SizedBox(height: 12),

              _buildStatusCard(
                context,
                status: widget.aluno['status']?.toString() ?? 'inativo',
              ),

              const SizedBox(height: 24),
            ],
          ),
        ),
      ),
    );
  }

  Widget _buildInfoCard(
      BuildContext context, {
        required IconData icon,
        required String label,
        required String value,
        required Color color,
      }) {
    return Container(
      padding: const EdgeInsets.all(16),
      decoration: BoxDecoration(
        color: AppTheme.cardBackground.withAlpha(200),
        borderRadius: BorderRadius.circular(16),
        border: Border.all(
          color: color.withAlpha(100),
        ),
        boxShadow: [
          BoxShadow(
            color: Colors.black.withAlpha(100),
            blurRadius: 8,
          ),
        ],
      ),
      child: Row(
        children: [
          Container(
            padding: const EdgeInsets.all(12),
            decoration: BoxDecoration(
              color: color.withAlpha(200),
              borderRadius: BorderRadius.circular(12),
            ),
            child: Icon(icon, color: Colors.white, size: 24),
          ),
          const SizedBox(width: 16),
          Expanded(
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                Text(
                  label,
                  style: const TextStyle(
                    color: AppTheme.textSecondary,
                    fontSize: 12,
                  ),
                ),
                const SizedBox(height: 4),
                Text(
                  value,
                  style: const TextStyle(
                    color: AppTheme.textPrimary,
                    fontSize: 16,
                    fontWeight: FontWeight.bold,
                  ),
                ),
              ],
            ),
          ),
        ],
      ),
    );
  }

  Widget _buildStatusCard(
      BuildContext context, {
        required dynamic status,
      }) {
    final s = status?.toString().trim().toLowerCase() ?? '';
    final isAtivo = s == '1' || s == 'true' || s == 'ativo';
    final display = isAtivo ? 'Ativo' : 'Inativo';
    final color =
    isAtivo ? AppTheme.successColor : AppTheme.errorColor;

    return Container(
      padding: const EdgeInsets.all(16),
      decoration: BoxDecoration(
        color: color.withAlpha(50),
        borderRadius: BorderRadius.circular(16),
        border: Border.all(
          color: color.withAlpha(150),
          width: 2,
        ),
      ),
      child: Row(
        children: [
          Icon(
            isAtivo ? Icons.check_circle : Icons.cancel,
            color: color,
            size: 24,
          ),
          const SizedBox(width: 16),
          Text(
            display,
            style: TextStyle(
              color: color,
              fontSize: 16,
              fontWeight: FontWeight.bold,
            ),
          ),
        ],
      ),
    );
  }
}
