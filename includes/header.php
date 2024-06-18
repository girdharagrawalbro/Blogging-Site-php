<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responsive Navigation Bar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Custom CSS for suggestion list */
        .suggestion-list {
            position: absolute;
            margin-top: 3rem;
            padding: 5px 0;
            background-color: #fff;
            border-radius: 0.25rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            list-style: none;
            z-index: 1000;
            /* Ensure the list appears on top of other elements */
        }

        .suggestion-list li {
            padding: 5px 10px;
        }

        .suggestion-list li a {
            color: #333;
            text-decoration: none;
        }

        .suggestion-list li:hover {
            background-color: #f8f9fa;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <h3 class="">Code With Girdhar</h3>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">Category</a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <?php include "admin/database/queries.php"; 
                            foreach($category_data as $row) {?>
                            <li><a class="dropdown-item" href="index.php?category=<?php echo $row['name']; ?>"><?php echo $row['name']; ?></a></li>
                            <?php } ?>
                        </ul>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="about.php">About</a></li>
                    <li class="nav-item"><a class="nav-link" href="contact.php">Contact</a></li>
                </ul>
                <form class="d-flex ms-auto" action="./index.php" method="post">
                    <input class="form-control me-2" type="text" id="searchInput" placeholder="Search" name="query"
                        aria-label="Search" minlength="2" onkeyup="getSuggestions()">
                    <ul id="suggestionList" class="suggestion-list"></ul>
                    <button class="btn btn-outline-success" type="submit" name="submit">Search</button>
                </form>
            </div>
        </div>
    </nav>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
    <script>
        function getSuggestions() {
            var query = document.getElementById('searchInput').value;
            if (query === '') {
                document.getElementById('suggestionList').innerHTML = ''; // Clear suggestion list if query is empty
                return;
            }

            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    var suggestions = JSON.parse(this.responseText);
                    var suggestionList = document.getElementById('suggestionList');
                    suggestionList.innerHTML = ''; // Clear previous suggestions
                    suggestions.forEach(function (suggestion) {
                        var listItem = document.createElement('li');
                        var link = document.createElement('a');
                        link.setAttribute('class', 'nav-link text-dark');
                        link.setAttribute('href', 'post.php?id=' + suggestion.ID);
                        link.textContent = suggestion.title;
                        listItem.appendChild(link);
                        suggestionList.appendChild(listItem);
                    });
                }
            };

            xmlhttp.open('GET', 'includes/suggestion.php?query=' + query, true);
            xmlhttp.send();
        }
    </script>
</body>

</html>
