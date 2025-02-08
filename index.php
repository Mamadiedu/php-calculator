<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CALCULATOR</title>
    <style>
        body {
            background-color: lightseagreen;
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .calculator {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.3);
            text-align: center;
            width: 320px;
        }
        h2 {
            margin-bottom: 10px;
        }
        input {
            width: 100%;
            height: 50px;
            font-size: 24px;
            text-align: right;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 5px;
        }
        .buttons {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 10px;
        }
        button {
            width: 100%;
            height: 60px;
            font-size: 20px;
            cursor: pointer;
            border: none;
            border-radius: 5px;
        }
        .btn-clear { background-color: red; color: white; grid-column: span 2; }
        .btn-equal { background-color: orange; color: white; grid-column: span 2; }
        .btn-operator { background-color: lightgray; }
    </style>
</head>
<body>

<div class="calculator">
    <h2>CALCULATOR</h2>
    <form method="POST">
        <input type="text" name="display" id="display" value="<?= isset($_POST['display']) ? htmlspecialchars($_POST['display']) : '' ?>" readonly>
        <div class="buttons">
            <button type="submit" name="display" value="<?= $_POST['display'] ?? '' ?> log">log</button>
            <button type="submit" name="display" value="<?= $_POST['display'] ?? '' ?> sqrt">√</button>
            <button type="submit" name="display" value="<?= $_POST['display'] ?? '' ?> %">%</button>
            <button type="submit" name="display" value="<?= substr($_POST['display'] ?? '', 0, -1) ?>">←</button>

            <button type="submit" name="display" value="<?= $_POST['display'] ?? '' ?>7">7</button>
            <button type="submit" name="display" value="<?= $_POST['display'] ?? '' ?>8">8</button>
            <button type="submit" name="display" value="<?= $_POST['display'] ?? '' ?>9">9</button>
            <button type="submit" name="display" value="<?= $_POST['display'] ?? '' ?> /" class="btn-operator">/</button>

            <button type="submit" name="display" value="<?= $_POST['display'] ?? '' ?>4">4</button>
            <button type="submit" name="display" value="<?= $_POST['display'] ?? '' ?>5">5</button>
            <button type="submit" name="display" value="<?= $_POST['display'] ?? '' ?>6">6</button>
            <button type="submit" name="display" value="<?= $_POST['display'] ?? '' ?> *" class="btn-operator">*</button>

            <button type="submit" name="display" value="<?= $_POST['display'] ?? '' ?>1">1</button>
            <button type="submit" name="display" value="<?= $_POST['display'] ?? '' ?>2">2</button>
            <button type="submit" name="display" value="<?= $_POST['display'] ?? '' ?>3">3</button>
            <button type="submit" name="display" value="<?= $_POST['display'] ?? '' ?> -" class="btn-operator">-</button>

            <button type="submit" name="display" value="<?= $_POST['display'] ?? '' ?> ^">^</button>
            <button type="submit" name="display" value="<?= $_POST['display'] ?? '' ?>0">0</button>
            <button type="submit" name="display" value="<?= $_POST['display'] ?? '' ?> .">.</button>
            <button type="submit" name="display" value="<?= $_POST['display'] ?? '' ?> +" class="btn-operator">+</button>

            <button type="submit" class="btn-clear" name="display" value="">C</button>
            <button type="submit" class="btn-equal" name="calculate" value="=">=</button>
        </div>
    </form>

    <?php
    if (isset($_POST['calculate'])) {
        $input = $_POST['display'];

        // Replace ^ with ** for exponentiation in PHP
        $input = str_replace("^", "**", $input);

        // Handle square root function
        if (strpos($input, "sqrt") !== false) {
            $number = floatval(str_replace("sqrt", "", $input));
            $result = sqrt($number);
        }
        // Handle logarithm function
        elseif (strpos($input, "log") !== false) {
            $number = floatval(str_replace("log", "", $input));
            if ($number > 0) {
                $result = log($number);
            } else {
                $result = "Error";
            }
        }
        // Handle percentage calculations correctly (e.g., 100000 * 10%)
        elseif (preg_match('/([\d.]+)\s*\*\s*([\d.]+)%/', $input, $matches)) {
            $result = ($matches[1] * $matches[2]) / 100;
        }
        // If user inputs a single number with %, convert it to its fraction (e.g., 10% -> 0.1)
        elseif (strpos($input, "%") !== false) {
            $result = eval("return (" . str_replace('%', '/100', $input) . ");");
        }
        // Evaluate mathematical expressions safely
        else {
            try {
                $result = eval("return $input;");
                if ($result === false) {
                    $result = "Error";
                }
            } catch (Throwable $e) {
                $result = "Error";
            }
        }

        echo "<script>document.getElementById('display').value = '$result';</script>";
    }
    ?>
</div>

</body>
</html>
