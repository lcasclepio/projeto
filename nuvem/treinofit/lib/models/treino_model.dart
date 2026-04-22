class Treino {
  final int id;
  final String observacao;

  Treino({required this.id, required this.observacao});

  factory Treino.fromJson(Map json) {
    return Treino(
      id: json['id'],
      observacao: json['observacao_geral'] ?? '',
    );
  }
}
