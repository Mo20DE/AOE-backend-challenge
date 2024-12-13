<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/> 
        <link rel="stylesheet" href="src/styles.css">
        <title>DeeSee Heroes System</title>
    </head>
    <body>
        <header>
            <h1>Superhero Platform</h1>
        </header>
        <main>
            <section class="first-section">
                <form>
                    <span>Select HTTP-Method:</span>
                    <input type="radio" id="get" name="http-methods" value="GET" checked>
                    <label for="get">GET</label>
                    <input type="radio" id="post" name="http-methods" value="POST">
                    <label for="post">POST</label>
                    <!-- <input type="radio" id="put" name="http-methods" value="PUT">
                    <label for="put">PUT</label>
                    <input type="radio" id="delete" name="http-methods" value="DELETE">
                    <label for="delete">DELETE</label> -->
                </form>
            </section>
            
            <section class="section-content get-section ">
            <!-- action="webservices/rest-api.php" method="GET" -->
                <form id="get-form">
                    <span>Select Filters:</span>
                    <input type="checkbox" id="opt1" name="str" class="filters" checked>
                    <label for="opt1">Strength</label>
                    <input type="checkbox" id="opt2" name="spd" class="filters" checked>
                    <label for="opt2">Speed</label>
                    <input type="checkbox" id="opt3" name="fly" class="filters" checked>
                    <label for="opt3">Flight</label>
                    <input type="checkbox" id="opt4" name="invul" class="filters" checked>
                    <label for="opt4">Invulnerability</label>
                    <input type="checkbox" id="opt5" name="heal" class="filters" checked>
                    <label for="opt5">Healing</label> <br><br><br><br>

                    <span>Use DeeSee-Encryption:</span>
                    <input type="radio" id="no" name="enc" value="off">
                    <label for="no">No</label>
                    <input type="radio" id="yes" name="enc" value="on" checked>
                    <label for="yes">Yes</label> 

                    <span id="key-span">Key:</span>
                    <input type="number" id="key" name="key" value="5" min="1" max="28">
                </form>
            </section>

            <section class="section-content post-section ">
                <form id="post-form">
                    <h2>Create new Superhero:</h2>
                    <span>Name: </span>
                    <input type="text" id="nm" name="nm" class="input" placeholder="aquaman" required> <br><br>
                    <span>First Name:</span>
                    <input type="text" id="fn" name="fn" class="input" placeholder="arthur" required> <br><br>
                    <span>Last Name:</span>
                    <input type="text" id="ln" name="ln" class="input" placeholder="curry" required> <br><br>
                    <span>Date of Birth:</span>
                    <input type="date" id="dob" name="dob" value="1986-01-29" required> <br><br>

                    <span>Select Superpowers:</span>
                    <input type="checkbox" id="opt6" name="str" class="suppwrs" checked>
                    <label for="opt6">Strength</label>
                    <input type="checkbox" id="opt7" name="spd" class="suppwrs">
                    <label for="opt7">Speed</label>
                    <input type="checkbox" id="opt8" name="fly" class="suppwrs">
                    <label for="opt8">Flight</label>
                    <input type="checkbox" id="opt9" name="invul" class="suppwrs">
                    <label for="opt9">Invulnerability</label>
                    <input type="checkbox" id="opt10" name="heal" class="suppwrs">
                    <label for="opt10">Healing</label> 
                </form>
            </section>

            <button id="submit-button">Send Request</button>
        </main>

        <div id="result">
            <p >Server Response: </p>
        </div>

        <script src="index.js"></script>
    </body>
</html>
