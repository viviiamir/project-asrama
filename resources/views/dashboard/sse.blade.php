@extends('layouts.app')

@section('title', 'Realtime SSE')

@section('content')
    <h2>📢 Notifikasi Real-Time (SSE)</h2>
    <ul id="notif-list" class="list-group"></ul>
@endsection

@section('scripts')
<script>
    const source = new EventSource("http://localhost/asrama_iot/api/events.php");

    source.addEventListener("notification", function(e) {
        const data = JSON.parse(e.data);
        const li = document.createElement("li");
        li.classList.add("list-group-item");
        li.innerHTML = `
            <strong>${data.type}</strong> - ${data.message}
            <span class="badge ${data.status === 'ACTIVE' ? 'bg-danger' : 'bg-success'}">${data.status}</span>
            <br><small>${data.created_at}</small>
        `;
        document.getElementById("notif-list").prepend(li);
    });

    source.onerror = function(err) {
        console.error("SSE error:", err);
    };
</script>
@endsection
