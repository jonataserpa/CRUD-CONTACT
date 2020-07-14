
<?php 
    session_start();
    INCLUDE("app/model/VerificaSessao.php"); 
?>
<!DOCTYPE html>
<html lang="pt-br" dir="ltr">

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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/all.min.js" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.11"></script>
    <script src="https://cdn.jsdelivr.net/npm/v-mask/dist/v-mask.min.js"></script>

</head>

<body>
    <div id="app">
        <nav class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
            <a class="navbar-brand col-md-3 col-lg-2 mr-0 px-3" href="#">Cohros -> Test</a>
            <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-toggle="collapse"
                data-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <input class="form-control form-control-dark w-100" type="text" v-model="keywords" v-on:keyup="search" 
                placeholder="Search">
            <ul class="navbar-nav px-3">
                <li class="nav-item text-nowrap">
                    <a class="nav-link" href="logout">Sign out</a>
                </li>
            </ul>
        </nav>

        <div class="container-fluid">
            <div class="row">
                <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
                    <div class="sidebar-sticky pt-3">
                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <a class="nav-link" href="#">
                                    <span data-feather="file"></span>
                                    Contact ->
                                </a>
                            </li>

                        </ul>
                    </div>
                </nav>

                <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">

                    <div
                        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                        <h5 class="h4">List Contacts -> </h5>
                        <div class="btn-toolbar mb-2 mb-md-0">
                            <div class="btn-group mr-2">
                                <button v-on:click="openForm(true)" data-toggle="modal" data-target="#modalForm"
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
                                    <h4 class="modal-title">{{ modal.title }} -> Contact</h4>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>

                                <form class="formulario">
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label>Full name <span class="red-alert">{{error.name}}</span></label>
                                                <input ref="name" v-model="contact.name" type="text"
                                                    class="form-control" placeholder="Full name" id="name">
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label>Email <span class="red-alert">{{error.email}}</span></label>
                                                <input v-model="contact.email" type="email" class="form-control"
                                                    placeholder="email@domain.com" id="email"
                                                    v-on:blur="validaEmail(contact.email)" />
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label>Address <span class="red-alert">{{error.address}}</span></label>
                                            <input v-model="contact.address" type="text" id="address"
                                                placeholder="Address"
                                                data-prepend="<span class='mif-import-contacts'></span>"
                                                class="form-control" />
                                        </div>
                                        <br>

                                        <div class="row">
                                            <div class="form-group mx-sm-3 mb-2">
                                                <label for="tipo" class="sr-only">TIPO</label>
                                                <select id="tipo" class="custom-select">
                                                    <option selected>Open this select menu</option>
                                                    <option value="Personal">Personal</option>
                                                    <option value="Sales">Sales</option>
                                                    <option value="Work">Work</option>
                                                    <option value="Commercial">Commercial</option>
                                                </select>
                                            </div>

                                            <div class="form-group mx-sm-3 mb-2">
                                                <label for="phone" class="sr-only">PHONE</label>
                                                <input type="text" class="form-control" name="phone" id="phone"
                                                    v-mask="mask" v-model="phone" placeholder="(99) 9999-9999" />
                                            </div>

                                            <div class="form-group col-sm-1" v-on:click="addPhone()"
                                                style="padding-top: 10px; padding-left: 20px;">
                                                <a><img src="img/plus.PNG" title="Add Phone?" class="img"
                                                        alt="Inserir"></a>
                                            </div>
                                        </div>

                                        <div class="table-responsive">
                                            <table id="table-phone" class='table table-striped table-sm'>
                                                <thead>
                                                    <tr>
                                                        <th style='width: 5%'>TIPO</th>
                                                        <th style='width: 50%'>TELEFONE</th>
                                                        <th style='width: 5%'>#</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="tbody-telefone">
                                                    <tr v-for="(phone, index) in contact.phones">
                                                        <td>{{ phone.p_tipo }}</td>
                                                        <td>{{ phone.p_numero }}</td>
                                                        <td v-on:click="removePhone(index)"><i title="remover phone?"
                                                                class="far fa-times-circle"></i></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                </form>

                                <div class="modal-footer">
                                    <span>{{messageResult}}</span>
                                    <button v-on:click="merge" :disabled="disabledButton" class="btn btn-success"><i
                                            class="fa fa-share-square"></i>&nbsp; Save</i> </button>
                                    <button v-on:click="openForm(false)" type="button" class="btn btn-secondary"
                                        data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Address</th>
                                    <th>x</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for=" (contact, index) in contacts " :key="index"
                                    v-on:dblclick="editContact(contact)">
                                    <td>{{ contact.c_id }}</td>
                                    <td>{{ contact.c_name }}</td>
                                    <td>{{ contact.c_email }}</td>
                                    <td>{{ contact.c_address }}</td>
                                    <td v-on:click="removeContact(contact)"><i title="Remove contact?"
                                            class="far fa-times-circle"></i></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                </main>

            </div>
        </div>
    </div>

    <script src="js/jquery-3.3.1.min.js" charset="utf-8"></script>
    <script src="metroui/js/metro.min.js" charset="utf-8"></script>

    <!-- <script src="js/vue.js" charset="utf-8"></script> -->

    <script src="js/axios.min.js" charset="utf-8"></script>
    <script src="js/vue-contact.js" charset="utf-8"></script>
    <script src="assets/dist/js/bootstrap.bundle.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.9.0/feather.min.js"></script>
    <script src="js/dashboard.js"></script>

</body>

</html>