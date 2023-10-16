<html>
    <head>
        <title>ToucanTech Coding Task</title>
        <link rel="icon" type="image/png" href="https://toucantech.com/uploads/default/customization/FAVICON.png">
        <!-- You mentioned the primary frontend tools are Bootstrap and JQuery so I assumed it was fair to use them on this -->
        <!-- page. I would have also been fine using vanilla JavaScript, but thought using your tools would make me look better -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    </head>
    <body class="container">
        <header>
            <h1>Toucan Tech Coding Task</h1>
        </header>

        <main>
            <div class="row g-3 justify-content-md-center">
                <div class="col-auto">
                    <input type="text" class="form-control" id="search" placeholder="Search Name">
                </div>
                <div class="col-auto">
                    <button type="button" class="btn btn-primary mb-3" id="searchButton">Search</button>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <p class="lead text-center" id="initialMessage">
                        Any search results will show here after clicking the search button above
                    </p>

                    <table class="table table-striped table-hover" style="display: none;" id="searchTable">
                        <thead>
                        <tr>
                            <th scope="col">First name</th>
                            <th scope="col">Last Name</th>
                            <th scope="col">email address</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr id="noResults">
                            <td colspan="3" class="text-center">No results found.</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>

        <script src="https://cdn.jsdelivr.net/gh/jquery/jquery@3.7.1/dist/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
        <script>
            let searchRequest;
            $(document).ready(function () {
                $('#searchButton').click(function () {
                    // If we are already are making a search request lets abort that and make a fresh one
                    // with the updated search term.
                    if (searchRequest) {
                        searchRequest.abort();
                    }

                    // Do a backend search to retrieve any matches to the search term
                    $.get('index.php?route=searchNames&term=' + $('#search').val(), function (data) {
                        // Remove the initial message and any old profile rows
                        $('main div.card p#initialMessage').fadeOut(function () {
                            // Fade in the search table after the initial search message has faded out
                            $('table#searchTable').fadeIn();
                        });
                        $('table#searchTable tbody tr.profileRow').remove();

                        if (data.length) {
                            // Hide no results row
                            $('table#searchTable tbody tr#noResults').hide();

                            $.each(data, function (index, profile) {
                                $('table#searchTable tbody').append("<tr class='profileRow'><td>" + profile.Firstname
                                    + "</td><td>" + profile.Surname + "</td><td>" + profile.emailaddress + "</td></tr>");
                            });
                        }
                        else {
                            // Show no results row
                            $('table#searchTable tbody tr#noResults').show();
                        }
                    });
                });
            });
        </script>
    </body>
</html>