class Formatters {
  static String cpf(String value) {
    value = value.replaceAll(RegExp(r'\D'), '');
    if (value.length != 11) return value;

    return "${value.substring(0,3)}."
        "${value.substring(3,6)}."
        "${value.substring(6,9)}-"
        "${value.substring(9)}";
  }
}
