class Aluno {
  final int id;
  final String nome;
  final String plano;
  final String status;
  final String mensalidade;

  Aluno({
    required this.id,
    required this.nome,
    required this.plano,
    required this.status,
    required this.mensalidade,
  });

  factory Aluno.fromJson(Map json) {
    return Aluno(
      id: json['id'],
      nome: json['nome'],
      plano: json['plano'],
      status: json['status'].toString(),
      mensalidade: json['mensalidade'].toString(),
    );
  }
}
