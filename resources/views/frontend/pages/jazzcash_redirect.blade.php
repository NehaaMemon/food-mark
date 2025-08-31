<!DOCTYPE html>
<html>
<head><meta charset="utf-8"><title>Redirecting to JazzCash...</title></head>
<body onload="document.forms['jazzcash_form'].submit()">
    <h3>Redirecting to JazzCash — please wait...</h3>


    <pre style="background:#f6f6f6;padding:.5rem;border:1px solid #ddd;">
{{ print_r($data, true) }}
    </pre>

    <form name="jazzcash_form" method="POST"
        action="https://sandbox.jazzcash.com.pk/CustomerPortal/TransactionManagement/MerchantForm/">

        @foreach($data as $k => $v)
            <input type="hidden" name="{{ $k }}" value="{{ $v }}">
        @endforeach
    </form>
</body>
</html>
{{-- <!DOCTYPE html>
<html>
<head>
    <title>JazzCash Sandbox Debugging</title>
    <script>
        function validateAndSubmit() {
            let form = document.forms['jazzcash_form'];
            let requiredFields = [
                "pp_MerchantID",
                "pp_Password",
                "pp_TxnRefNo",
                "pp_Amount",
                "pp_TxnCurrency",
                "pp_TxnDateTime",
                "pp_ReturnURL",
                "pp_SecureHash"
            ];

            for (let i = 0; i < requiredFields.length; i++) {
                let field = form[requiredFields[i]];
                if (!field || field.value.trim() === "") {
                    alert("Missing or invalid field: " + requiredFields[i]);
                    return false; // stop submission
                }
            }

            // All good → submit form
            form.submit();
        }
    </script>
</head>
<body>
    <h2>JazzCash Sandbox Payment Debugging</h2>
    <p><b>Sandbox URL:</b> {{ "https://sandbox.jazzcash.com.pk/CustomerPortal/TransactionManagement/MerchantForm/" }}</p>

    <h3>Form Fields</h3>
    <table border="1" cellpadding="5" cellspacing="0">
        <tr>
            <th>Field</th>
            <th>Value</th>
        </tr>
        @foreach($data as $key => $value)
        <tr>
            <td>{{ $key }}</td>
            <td>{{ $value }}</td>
        </tr>
        @endforeach
    </table>

    <br>

    <form name="jazzcash_form" method="POST" action="https://sandbox.jazzcash.com.pk/CustomerPortal/TransactionManagement/MerchantForm/">
        @foreach($data as $key => $value)
            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
        @endforeach
        <button type="button" onclick="validateAndSubmit()">Submit to JazzCash Sandbox</button>
    </form>

    <p style="color: red;">
        ⚠ Debug mode: Agar koi required field khali hoga to alert show hoga.
        Sahi hone par hi sandbox page par redirect karega.
    </p>
</body>
</html> --}}


