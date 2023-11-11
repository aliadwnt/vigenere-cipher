<?php

// Variable initialization
$key = "";
$text = "";
$error = "";
$color = "#FF0000";

// Check if data is sent via POST method
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if 'key' and 'text' data exist in $_POST
    if (isset($_POST['key']) && isset($_POST['text'])) {
        $key = $_POST['key'];
        $text = $_POST['text'];

        // If the encrypt or decrypt button is pressed
        if (isset($_POST['encrypt']) || isset($_POST['decrypt'])) {
            // Define encrypt and decrypt functions
            function encrypt($key, $text)
            {
                $ki = 0;
                $kl = strlen($key);
                $length = strlen($text);

                for ($i = 0; $i < $length; $i++) {
                    if (ctype_alpha($text[$i])) {
                        if (ctype_upper($text[$i])) {
                            $text[$i] = chr(((ord($text[$i]) - ord("A") + ord($key[$ki]) - ord("A")) % 26) + ord("A"));
                        } else {
                            $text[$i] = chr(((ord($text[$i]) - ord("a") + ord($key[$ki]) - ord("a")) % 26) + ord("a"));
                        }

                        $ki++;
                        if ($ki >= $kl) {
                            $ki = 0;
                        }
                    }
                }
                return $text;
            }

            function decrypt($key, $text)
            {
                $ki = 0;
                $kl = strlen($key);
                $length = strlen($text);

                for ($i = 0; $i < $length; $i++) {
                    if (ctype_alpha($text[$i])) {
                        if (ctype_upper($text[$i])) {
                            $x = ((ord($text[$i]) - ord("A")) - (ord($key[$ki]) - ord("A")) % 26);

                            if ($x < 0) {
                                $x += 26;
                            }

                            $x = $x + ord("A");

                            $text[$i] = chr($x);
                        } else {
                            $x = ((ord($text[$i]) - ord("a")) - (ord($key[$ki]) - ord("a")) % 26);

                            if ($x < 0) {
                                $x += 26;
                            }

                            $x = $x + ord("a");

                            $text[$i] = chr($x);
                        }

                        $ki++;
                        if ($ki >= $kl) {
                            $ki = 0;
                        }
                    }
                }
                return $text;
            }

            // If the encrypt button is pressed
            if (isset($_POST['encrypt'])) {
                $text = encrypt($key, $text);
                $error = "Text successfully encrypted!";
            }

            // If the decrypt button is pressed
            if (isset($_POST['decrypt'])) {
                $text = decrypt($key, $text);
                $error = "Text successfully decrypted!";
            }
        } else {
            $error = "Please complete all inputs!";
        }
    }
}

?>

<html>
<head>
    <title>Vigenere Cipher</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<br><br><br><br><br>
<main role="main" class="container">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card">
                <div class="card-header">
                    <caption><h2 style="text-align: center;"><b>Vigenere Cipher</b></h2></caption>
                </div>
                <div class="card-body">
                    <form action="index.php" method="post">
                        <div class="form-group">
                            <label for="Key">Key</label>
                            <input type="text" class="form-control" name="key" id="key"
                                   aria-describedby="inputKey" placeholder="Enter Key"
                                   value="<?php echo $key; ?>">
                        </div>
                        <div class="form-group">
                            <label for="Plaintext">Plaintext</label>
                            <textarea class="form-control" name="text" id="text"
                                      rows="5"><?php echo $text; ?></textarea>
                        </div>
                        <button type="submit" class="btn btn-success" name="encrypt" value="Encrypt">Encrypt</button>
                        <br><br>
                        <button type="submit" class="btn btn-danger" name="decrypt" value="Decrypt">Decrypt</button>
                    </form>
                </div>
                <div class="card-footer text-center text-success">
                    <strong><?php echo $error; ?></strong>
                </div>
            </div>
        </div>
    </div>
</main>
</body>
</html>
