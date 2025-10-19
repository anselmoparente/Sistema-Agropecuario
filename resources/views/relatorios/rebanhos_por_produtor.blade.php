<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatório Geral de Rebanhos</title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            color: #333;
            line-height: 1.6;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #eee;
            padding-bottom: 10px;
        }

        .header h1 {
            margin: 0;
            font-size: 24px;
        }

        h2.produtor-nome {
            font-size: 18px;
            margin-top: 30px;
            margin-bottom: 10px;
            background-color: #f7f7f7;
            padding: 8px;
            border-left: 4px solid #42A5F5;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        .no-data {
            text-align: center;
            padding: 20px;
            font-style: italic;
            color: #777;
        }

        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 10px;
            color: #aaa;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>Relatório Geral de Rebanhos</h1>
    </div>

    @forelse ($produtores as $produtor)
    <h2 class="produtor-nome">{{ $produtor->nome }}</h2>

    @if ($produtor->rebanhos->count() > 0)
    <table>
        <thead>
            <tr>
                <th>Propriedade</th>
                <th>Espécie</th>
                <th>Quantidade</th>
                <th>Finalidade</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($produtor->rebanhos as $rebanho)
            <tr>
                <td>{{ $rebanho->propriedade->nome ?? 'N/A' }}</td>
                <td>{{ $rebanho->especie }}</td>
                <td>{{ $rebanho->quantidade }}</td>
                <td>{{ $rebanho->finalidade ?: 'Não informada' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif
    @empty
    <p class="no-data">Nenhum produtor com rebanhos registados foi encontrado.</p>
    @endforelse

    <div class="footer">
        Gerado em {{ now()->format('d/m/Y H:i') }}
    </div>
</body>

</html>