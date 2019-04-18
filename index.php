<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <title>Lottery Permutation</title>

    <style>
        ol {
            column-count: 6;
        }
        ol li{
            margin: 0 30px;
        }
    </style>
</head>

<body >
    <div class="d-flex justify-content-center align-items-center h-100 m-5 flex-column">
        <h1 class="text-center">Lottery Permutation</h1>
        <p class="text-center">
            In this system you can input any integer number and the size of output
            <br>
            It'll find all the possible combination possible.
        </p>
        <br>
        <br>
        <br>
            <?php if (empty($_POST)): ?>
                <form action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?> method="post">
                    <div class="form-group">
                        <label for="inputedNumbers">Numbers To Permute (separate with comma and PLEASE, use zeroes before unities)</label>
                        <textarea class="form-control" id="inputedNumbers" name="inputedNumbers" rows="3" placeholder="01, 02, 10, 30, 70"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="outputSize">Output Size</label>
                        <input type="number" class="form-control" id="outputSize" name="outputSize"/>
                    </div>
                    <div class="form-group">
                        <input type="submit" class="btn btn-block btn-success" value="Permute!">
                    </div>
                </form>
            <?php else: ?>
                <a class="btn btn-block btn-primary" href="/">Back to input</a>
                <br>
                <br>
                <br>
                <h2 class="h3 text-center">Results</h2>
                <ol>
                <?php
                    ini_set('memory_limit', '-1');
                    $inputedNumbers = $_POST['inputedNumbers'];
                    $outputSize = $_POST['outputSize'];

                    //Creating an array based on input
                    $inputedNumbers = str_replace(' ', '', $inputedNumbers);
                    $inputedNumbers = explode(',', $inputedNumbers);
                    $inputedNumbers = array_filter($inputedNumbers);

                    //Permutation
                    function pc_permute($items, $perms = []) {
                        global $permutationResult;
                        if (empty($items)) { 
                            $permutationResult .= join(', ', $perms) . "|";
                        }  else {
                            for ($i = count($items) - 1; $i >= 0; --$i) {
                                $newitems = $items;
                                $newperms = $perms;
                                list($foo) = array_splice($newitems, $i, 1);
                                array_unshift($newperms, $foo);
                                pc_permute($newitems, $newperms);
                            }
                        }
                    }
                    pc_permute($inputedNumbers);
                    

                    //Formating output data
                    $permutationResult = str_replace(' ', '', $permutationResult);
                    $permutationResult = explode('|', $permutationResult);
                    $permutationResult = array_filter($permutationResult);


                    //Limiting output data
                    foreach($permutationResult as $key => &$result){
                        $result = substr($result, 0, $outputSize * 3 - 1);
                        $result = explode(',', $result);
                        sort($result);
                        if(isset($permutationResult[$key+1])){
                            $result1 = substr($permutationResult[$key+1], 0, $outputSize * 3 - 1);
                            $result1 = explode(',', $result1);
                            sort($result1);
                            if((count(array_unique(array_merge($result, $result1))) === count($result))){
                                unset($permutationResult[$key]);
                            }
                        }
                        //Starting to filter closer numbers
                        foreach($result as $index => $number){
                            if(isset($result[$index+1])){
                                if(intval($number)+1 == (intval($result[$index+1]))){
                                    if(isset($result[$index+2])){
                                        if(intval($number)+2 == intval($result[$index+2])){
                                            unset($permutationResult[$key]);
                                            break;
                                        }
                                    }
                                }
                            }
                        }
                    }
                    $permutationResult = array_filter($permutationResult);

                    //Printing Results
                    foreach( $permutationResult as $result){
                        $carry = "";
                        foreach ($result as $number){
                            $carry .= $number . ' ';
                        }
                        echo "<li>{$carry}</li>";
                    }
                    //print_r($permutationResult);
                    
                ?>
                </ol>
            <?php endif;?>
    </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>
</body>

</html>