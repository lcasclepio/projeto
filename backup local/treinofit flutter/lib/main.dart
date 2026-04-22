import 'package:flutter/material.dart';
import 'package:treinofit/core/theme/app_theme.dart';
import 'package:treinofit/screens/auth/login_page.dart';
import 'package:treinofit/screens/auth/esqueci_senha_page.dart';
import 'package:treinofit/screens/auth/nova_senha_page.dart';
import 'package:treinofit/screens/home/home_page.dart';

void main() {
  runApp(const MyApp());
}

class MyApp extends StatelessWidget {
  const MyApp({super.key});

  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      debugShowCheckedModeBanner: false,
      title: 'TreinoFit',
      theme: AppTheme.darkTheme,
      initialRoute: '/',
      routes: {
        '/': (_) => const LoginPage(),
        '/esqueci': (_) => EsqueciSenhaPage(),
        '/home': (context) {
          final args = ModalRoute.of(context)?.settings.arguments;

          if (args is Map) {
            return HomePage(
              aluno: Map<String, dynamic>.from(args),
            );
          }

          // fallback de segurança
          return const LoginPage();
        },
      },
      onGenerateRoute: (settings) {
        if (settings.name == '/nova_senha') {
          final cpf = settings.arguments as String;
          return MaterialPageRoute(
            builder: (_) => NovaSenhaPage(cpf: cpf),
          );
        }
        return null;
      },
    );
  }
}
