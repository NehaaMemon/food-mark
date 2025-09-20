<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Redirecting to JazzCash...</title>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; margin-top: 50px; }
        .debug-data {
            background:#f6f6f6;
            padding:.5rem;
            border:1px solid #ddd;
            margin: 20px auto;
            width: 80%;
            max-width: 600px;
            text-align: left;
            overflow-x: auto;
        }
        h3 { color: #333; }
        .important-note { color: red; font-weight: bold; margin-top: 30px; }
    </style>
</head>
<body onload="document.forms['jazzcash_form'].submit()">
    <h3>Redirecting to JazzCash — please wait...</h3>
    <p class="important-note">DEBUG MODE: Neeche JazzCash ko bheja jaane wala data dikhaya ja raha hai. Agar koi masla hai to yahan check karen.</p>

    <pre class="debug-data">
Form Action: {{ config('jazzcash.environment') === 'sandbox' ? config('jazzcash.sandbox_url') : config('jazzcash.live_url') }}
{{ print_r($data, true) }}
    </pre>

    <form name="jazzcash_form" method="POST"
        action="{{ config('jazzcash.environment') === 'sandbox' ? config('jazzcash.sandbox_url') : config('jazzcash.live_url') }}">
        @foreach($data as $k => $v)
            <input type="hidden" name="{{ $k }}" value="{{ $v }}">
        @endforeach
    </form>
</body>
</html>
