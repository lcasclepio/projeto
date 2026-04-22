class Exercicio {
  final String nome;
  final String comentario;
  final String? descricao;
  final String? series;
  final String? repeticoes;
  final String? peso;

  Exercicio({
    required this.nome,
    required this.comentario,
    this.descricao,
    this.series,
    this.repeticoes,
    this.peso,
  });

  factory Exercicio.fromJson(Map json) {
    return Exercicio(
      nome: json['nome'] ?? '',
      comentario: json['comentario'] ?? '',
      descricao: json['descricao'],
      series: json['series']?.toString(),
      repeticoes: json['repeticoes']?.toString(),
      peso: json['peso']?.toString(),
    );
  }
}
