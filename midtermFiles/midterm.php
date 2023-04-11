<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <!-- Set the viewport so this responsive site displays correctly on mobile devices -->
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Include bootstrap CSS -->
        <link rel="stylesheet" href="http://netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
        <!-- Include jQuery library -->
        <script src="https://ajax.googleapis.com/ajaxbr/bs/jquery/1.11.0/jquery.min.js"></script>

        <title>CS382 Fall 2021 Midterm Exam</title>
        <style>
            p, table {margin-left: 50px;}
            .datagrid { width: 400px;}
            .hrule { border-top: 1px solid #000}
            .listItem { padding: 6px;}
        </style>
    </head>
    <body>
        <div class='container-fluid'>
            <h3>Problem 1: Compute Net Income</h3>

            <form action="problem1.php" method="post">
                <table class='table table-bordered datagrid'>
                    <tr>
                        <td><label for='income' >Gross Income:</label><input type='text' name="grossIncome" class='form-control' id="income" required></td>
                    </tr>
                    <tr>
                        <td><label for='dependents' >Number of Dependents: </label>
                            <select name="dependents" class="listItem" id="dependents">
                                <option value="0" >None</option>
                                <option value="1" >One</option>
                                <option value="2" >Two</option>
                                <option value="3" >Three</option>
                                <option value="4" >Four or more</option>
                        </td>
                    </tr>
                </table>

                <p><input type='submit' name='submit' value="Display Net Income" class='btn btn-primary'>
                <input type='reset' class='btn btn-default'></p>
            </form>

            <hr class="hrule"></hr>

            <h3>Problem 2: Estimate Rental Charge</h3>
            <form action="problem2.php" method="post">
                <p>Select Vehicle Type:<br/>
                    <input type='radio' name="category"  value='car' > Car<br/>
                    <input type='radio' name="category"  value='suv'> SUV<br/>
                    <input type='radio' name="category"  value='minivan'> Minivan<br/>
                </p>
                    
                <p>Number of Days:  <input type='number' min="0" name="numDays" placeholder="Enter number of days" required/></p>
                <p><input type='checkbox' name='coverage' > Add collision damage coverage : $20 per day</p>

                <p><input type='submit' name='submit' value="Estimate Rental Charges" class='btn btn-primary'>
                <input type='reset' class='btn btn-default'></p>
            </form>

            <hr class="hrule"></hr>

            <h3>Problem 3: Display a list of Members (first name, last name, phone, member type) based on the selected member type(s) from the following list:</h3>
            <form action="problem3.php" method="post">
                <p>Select member type:</p>
                <p>
                    <input type='checkbox' name='Preferred' > Preferred<br/>
                    <input type='checkbox' name='Regular' > Regular<br/>
                    <button type="submit" class="btn btn-primary">Display Members</button>
                </p>
            </form>

            <hr class="hrule"></hr>

            <h3>Problem 4: Compute the number of containers needed to complete the order</h4>
            <form method="post" action="problem4.php">
                <table class="table" style="width: 200px">
                    <tbody>
                        <tr>
                            <td>Length:  </td>
                            <td><input type='number'  name="cartLength" placeholder="Enter the length of the container" required/></td>
                        </tr>
                        <tr>
                            <td>Height:  </td>
                            <td><input type='number'  name="cartHeight" placeholder="Enter the height of the container" required/></td>
                        </tr>
                        <tr>
                            <td>Distance:  </td>
                            <td><input type='number'  name="distance" placeholder="Enter the distance" required/></td>
                        </tr>
                    </tbody>
                </table>
                <p><input type='submit' name='submit' value="Estimate Transportation Charges" class='btn btn-primary'>
                    <input type='reset' class='btn btn-default'>
                </p>
            </form>
        </div>
    </body>
</html>