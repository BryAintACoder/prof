<!DOCTYPE html>
<html>
<head>
	<title>FEUTOR</title>
	<script>
		function redirect() {
    var role = document.getElementById("role").value;
    if (role === "student") {
        window.location.href = "s-registration.php";
    } else if (role === "student-tutor") {
        window.location.href = "t-registration.php";
    }
}
	</script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FEUTOR - Welcome</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
        }
        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        h1 {
            color: #007bff;
        }
        h2 {
            color: #6c757d;
        }
        form {
            margin-top: 20px;
        }
    </style>
</head>
<body>
<div class="container">
        <h1>FEUTOR</h1>
        <h2>WELCOME!</h2>
        <p>FEUTOR is a tutor booking website for FEU Roosevelt students.</p>
        <form onsubmit="redirect(); return false;">
            <label for="role">SELECT YOUR ROLE:</label>
            <select id="role" name="role" class="form-select mb-3">
                <option value="student">Student</option>
                <option value="student-tutor">Student-Tutor</option>
            </select>
            <input type="submit" value="Submit" class="btn btn-primary">
        </form>
    </div>
</body>
</html>
