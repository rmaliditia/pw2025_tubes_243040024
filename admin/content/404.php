<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>404 Not Found</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            background-color: black;
            color: #00ff00;
            font-family: "Courier New", Courier, monospace;
            margin: 0;
            padding: 0;
            overflow: hidden;
        }

        .terminal {
            padding: 50px;
            max-width: 800px;
            margin: auto;
            white-space: pre-wrap;
            word-wrap: break-word;
        }

        .glitch {
            color: #00ff00;
            animation: glitch 0.3s infinite;
        }

        @keyframes glitch {
            0% {
                text-shadow: 1px 0 red, -1px 0 blue;
            }

            20% {
                text-shadow: -2px 0 red, 2px 0 blue;
            }

            40% {
                text-shadow: 1px 0 red, -1px 0 blue;
            }

            60% {
                text-shadow: -1px 0 red, 1px 0 blue;
            }

            80% {
                text-shadow: 2px 0 red, -2px 0 blue;
            }

            100% {
                text-shadow: 0 0 red, 0 0 blue;
            }
        }

        .cursor {
            display: inline-block;
            width: 10px;
            background-color: #00ff00;
            animation: blink 0.8s infinite;
            height: 18px;
        }

        @keyframes blink {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0;
            }
        }
    </style>
</head>

<body>
    <div class="terminal" id="terminal">
        <span class="glitch">root@server:~$</span> <span id="type-text"></span><span class="cursor"></span>
    </div>

    <script>
        const text = `
ERROR 404 - FILE NOT FOUND
==========================
We're watching you.
Your attempt to access a forbidden file has been logged.

Initiating reverse trace...

> IP Logged
> Port Scanning...
> Malware Injected Successfully ✔

Press BACK before we dig deeper... 😈
`;

        const typeText = document.getElementById('type-text');
        let index = 0;

        function typeEffect() {
            if (index < text.length) {
                typeText.innerHTML += text.charAt(index);
                index++;
                setTimeout(typeEffect, Math.random() * 50 + 10);
            }
        }

        window.onload = typeEffect;
    </script>
</body>

</html>