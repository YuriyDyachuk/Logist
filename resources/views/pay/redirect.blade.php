<form id="redirectForm" action="{{ $action }}" method="post">
    @foreach ($fields as $name => $value)
        <input type="hidden" name="{{ $name }}" value="{{ $value }}">
    @endforeach
</form>
<script type="text/javascript">
    document.getElementById('redirectForm').submit();
</script>