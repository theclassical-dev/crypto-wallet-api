<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- <script type="module" src="{{ asset('rapidoc-min.js') }}"></script> --}}
    {{-- <script type="module" src="/rapidoc-min.js"></script> --}}
    <script type="module" src="https://unpkg.com/rapidoc/dist/rapidoc-min.js"></script>
    <title>API Documentation</title>
</head>
<body>
    <rapi-doc spec-url="data:text/plain;base64,{{ base64_encode($apiDoc) }}"></rapi-doc>
</body>
</html>
