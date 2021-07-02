This project represents a basic php websocket client for the codenjoy platform.
It allows you to easily and quickly join the game, developing your unique algorithm, having a configured infrastructure.

# What do you need to get started?
To get started, you should define the desired game and enter a value in `$game` variable of `index.php` script. \
The second important thing is the connection token to the server. After successful authorization on the site, you must copy the url
and enter a value in `$url` variable of `index.php` script. \
This is enough to connect and participate in the competition.

# How to run it?
To start a project from the console window, you must first load dependencies by using [composer](https://getcomposer.org/doc/00-intro.md) `php composer.phar update`.
The entry point for starting a project is `index.php` file. \
You can pass the game type and token connection to the server as command-line arguments.
Game parameters passed by arguments at startup have a higher priority than those defined in the code.

To run scripts you need to execute a command `php index.php [<game>] [<url>]`

# How does it work?
The elements on the map are defined in `games/<gamename>/Element`. They determine the meaning of a particular symbol.
The two important components of the game are the `games/<gamename>/Board` board and the `games/<gamename>/Solver` solver.

Every second the server sends a string representation of the current state of the board, which is parsed in an object of class `Board`.
Then the server expects a string representation of your bot's action that is computed by executing `Solver.answer(message)`.

Using the set of available methods of the `Board` class, you improve the algorithm of the bot's behavior.
You should develop this class, extending it with new methods that will be your tool in the fight.
For example, a bot can get information about an element in a specific coordinate by calling `GameBoard.getAt(pt)`
or count the number of elements of a certain type near the coordinate by calling `GameBoard.countNear(pt, elements[])`, etc.

# Business logic testing
Writing tests will allow you to create conclusive evidence of the correctness of the existing code.
This is your faithful friend, who is always ready to answer the question: "Is everything working as I expect? The new code did not break my existing logic?". \
The `tests/games/<gamename>/BoardTest` class contains a set of tests that check board tools.
Implementation of new methods should be accompanied by writing new tests and checking the results of processing existing ones. \
Use `tests/games/<gamename>/SolverTest` to check the bot's behavior for a specific game scenario.