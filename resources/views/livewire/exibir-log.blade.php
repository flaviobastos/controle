<div>
    <table class="w-full text-center">
        <thead>
            <tr>
                <th>Data</th>
                <th>IP</th>
                <th>Usuario</th>
                <th>Mensagem</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($logs as $log)
                <tr class="border">
                    <td>{{ $log->created_at->format('d/m/Y H:i:s') }}</td> <!-- Formatação da data -->
                    <td>{{ $log->ip }}</td>
                    <td>{{ $log->usuario }}</td>
                    <td> {{ $log->mensagem }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
