<script>
    if (window.opener) {
        let channel = new BroadcastChannel('token')

        channel.postMessage("{{ $results }}")

        window.close()
    }
</script>
