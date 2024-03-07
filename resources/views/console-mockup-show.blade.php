<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Console Mockup</title>
    <style>
        /******* CONFIG *******/
/**********************/
/**** COLOR SCHEME ****/
/**********************/
body {
  background: url(console-background.jpg);
  background-repeat: no-repeat;
}
#terminal {
  width: 800px;
  height: 600px;
  margin: auto auto;
  background-color: #2d2d2d;
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  border-radius: 5px;
  box-shadow: 0px 0px 70px 7px rgba(0, 0, 0, 0.75);
  opacity: 1;
  padding: 10px;
  overflow-y: scroll;
}
.title {
    font-family: sans-serif;
  text-align: center;
  font-size: 0.75em;
  color: #999;
  height: 18px;
  position: relative;
  top: 2px;
}
.window {
  color: #d6d6d6;
  font-size: 14px;
  font-family: 'MesloLGS NF';
  overflow-wrap: break-word;
  line-height: 1.25em;
}
.icons {
  margin: 0;
  position: absolute;
  list-style: none;
  padding: 0;
}
ul.icons li {
  width: 12px;
  height: 12px;
  border-radius: 50%;
  display: inline-block;
}
ul.icons li.close {
  background-color: #ff5552;
}
ul.icons li.minimize {
  background-color: #ffbe42;
}
ul.icons li.maximize {
  background-color: #31c74a;
}
code {
  font-family: 'MesloLGS NF', monospace;
  display: block;
}
code:before {
  content: '>' ' ';
}
code.output:before,
code.out:before {
  content: '';
}
::selection {
  color: #2d2d2d;
  background: #d6d6d6;
}
code .fail {
    background: #ff5552;
    color: white;
}
.green {
  color: #52d305;
}
.red {
  color: #ff5552;
}
.yellow {
  color: #fee08a;
}
.blue {
  color: #99caf4;
}
.cyan {
  color: #79d4d5;
}
.magenta {
  color: #d6add5;
}
.black {
  color: #646464;
}
.bold {
  font-style: bold;
}
.italic {
  font-style: italic;
}
.underline {
  text-decoration: underline;
}


    </style>
</head>

<body>
    <div id="terminal">
        <ul class="icons">
            <li class="close"></li>
            <li class="minimize"></li>
            <li class="maximize"></li>
        </ul>
        <div class="title">bash</div>
        <div class="window">
            <pre>
                <code>php artisan exercise:show 1</code>
                <code class="output">  <span class="underline">Exercise</span>: Create a scheduled task</code>
                <code class="output">  Functional requirements</code><code class="output">    * Task must contain a title</code><code class="output">    * Task must be scheduled for a specific date or any week day</code><code class="output">    * Task must not be in the past</code><code class="output">    * Task days option must specify at least one day but as many as seven</code><br><code class="output">  Request fields</code><code class="output">    * title</code><code class="output">    * schedule_type</code><code class="output">    * date</code><code class="output">    * days[]</code><br><code class="output">  Database schema</code><code class="output">  +----------------+--------------+</code><code class="output">  | Field          | Type         |</code><code class="output">  +----------------+--------------+</code><code class="output">  | title          | VARCHAR(255) |</code><code class="output">  +----------------+--------------+</code><code class="output">  | schedule_type  | VARCHAR(255) |</code><code class="output">  +----------------+--------------+</code><code class="output">  | scheduled_date | DATE         |</code><code class="output">  +----------------+--------------+</code><code class="output">  | scheduled_days | VARCHAR(255) |</code><code class="output">  +----------------+--------------+</code><br><code class="output">  Open app/Http/Requests/01/ScheduledTaskCreateRequest.php to begin</code>
            </pre>
        </div>
    </div>
</body>

</html>
