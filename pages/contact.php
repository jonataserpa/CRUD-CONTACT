<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Jekyll v4.0.1">
    <title>Avaliação</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/4.5/examples/dashboard/">
    <link href="assets/dist/css/bootstrap.css" rel="stylesheet">
    <link href="css\style.css" rel="stylesheet">
</head>

<body>
    <nav class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
        <a class="navbar-brand col-md-3 col-lg-2 mr-0 px-3" href="#">Cohros</a>
        <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-toggle="collapse"
            data-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <input class="form-control form-control-dark w-100" type="text" placeholder="Search" aria-label="Search">
        <ul class="navbar-nav px-3">
            <li class="nav-item text-nowrap">
                <a class="nav-link" href="#">Sign out</a>
            </li>
        </ul>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
                <div class="sidebar-sticky pt-3">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link active" href="#">
                                <span data-feather="home"></span>
                                Dashboard <span class="sr-only">(current)</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <span data-feather="file"></span>
                                Orders
                            </a>
                        </li>

                    </ul>

                    <h6
                        class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                        <span>Saved reports</span>
                        <a class="d-flex align-items-center text-muted" href="#" aria-label="Add a new report">
                            <span data-feather="plus-circle"></span>
                        </a>
                    </h6>
                    <ul class="nav flex-column mb-2">
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <span data-feather="file-text"></span>
                                Current month
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
                <div id="app">
                    <div
                        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                        <h5 class="h4">List Contacts -> </h5>
                        <div class="btn-toolbar mb-2 mb-md-0">
                            <div class="btn-group mr-2">
                                <button v-on:click="OpenForm(true)" data-toggle="modal" data-target="#modalForm"
                                    type="button" class="btn btn-sm btn-outline-secondary">+
                                    Add Contact
                                </button>
                                <button type="button" class="btn btn-sm btn-outline-secondary">Export</button>
                            </div>
                        </div>
                    </div>

                    <div id="modalForm" class="modal fade">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">Add -> Contact</h4>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>

                                <form class="formulario">
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label>Full name <span class="red-alert">{{error.name}}</span></label>
                                                <input v-model="contact.name" type="text" class="form-control"
                                                    placeholder="Full name" id="email">
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label>Email <span class="red-alert">{{error.email}}</span></label>
                                                <input v-model="contact.email" type="email" class="form-control"
                                                    placeholder="email@domain.com" />
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label>Adrees <span class="red-alert">{{error.subject}}</span></label>
                                            <input v-model="contact.subject" type="text" placeholder="Adress"
                                                data-prepend="<span class='mif-import-contacts'></span>"
                                                class="form-control" />
                                        </div>
                                        <br>
                                        <div class="table-responsive">
                                            <table id="table-telefone" class='table table-striped table-sm'>
                                                <thead>
                                                    <tr>
                                                        <th style='width: 5%'>ID</th>
                                                        <th style='width: 50%'>TELEFONE</th>
                                                        <th style='width: 5%'>#</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="tbody-telefone">
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                </form>

                                <div class="modal-footer">
                                    <button v-on:click="Send" :disabled="disabledButton" class="btn btn-success"><i
                                            class="fa fa-share-square"></i>&nbsp; Save</i> </button>
                                    <span>{{messageResult}}</span>
                                    <button v-on:click="OpenForm(false)" type="button" class="btn btn-secondary"
                                        data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="table-responsive">
                    <table class="table table-striped table-sm">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Header</th>
                                <th>Header</th>
                                <th>Header</th>
                                <th>Header</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1,001</td>
                                <td>Lorem</td>
                                <td>ipsum</td>
                                <td>dolor</td>
                                <td>sit</td>
                            </tr>
                            <tr>
                                <td>1,002</td>
                                <td>amet</td>
                                <td>consectetur</td>
                                <td>adipiscing</td>
                                <td>elit</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </main>

        </div>
    </div>

    <script src="js/jquery-3.3.1.min.js" charset="utf-8"></script>
    <script src="metroui/js/metro.min.js" charset="utf-8"></script>

    <script src="js/vue.js" charset="utf-8"></script>
    <script src="js/axios.min.js" charset="utf-8"></script>
    <script src="js/vue-app.js" charset="utf-8"></script>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>

    <script src="https://unpkg.com/feather-icons/dist/feather.min.js"></script>

    </script>
    <script src="assets/dist/js/bootstrap.bundle.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.9.0/feather.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.min.js"></script>
    <script src="js/dashboard.js"></script>

</body>

</html>