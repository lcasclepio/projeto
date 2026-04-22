class Validators {
  static bool cpfValido(String cpf) {
    return cpf.replaceAll(RegExp(r'\D'), '').length == 11;
  }

  static bool senhaValida(String senha) {
    return senha.length >= 4;
  }
}
