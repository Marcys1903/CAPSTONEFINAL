<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Audit Logs - LGU Emergency System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        function showDetails(logId) {
            document.getElementById("auditModal-" + logId).classList.remove("hidden");
        }
        function closeDetails(logId) {
            document.getElementById("auditModal-" + logId).classList.add("hidden");
        }
    </script>
</head>

<body class="bg-gray-100 h-screen flex">