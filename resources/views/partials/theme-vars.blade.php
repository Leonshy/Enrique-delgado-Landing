<style>
    :root {
        @foreach(\App\Helpers\ThemeHelper::resolvedColors() as $var => $value)
        {{ $var }}: {{ $value }};
        @endforeach
    }
</style>
