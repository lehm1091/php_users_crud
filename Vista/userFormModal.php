    <!-- Modal -->
    <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/EXAMEN_SISTEMAS/Controlador/authorization_handler.php'; ?>
    
    <div class="modal fade" id="userFormModal" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Modal Header</h4>
                </div>
                <div class="modal-body">
                    <form class="col" id="userForm" action="" method="POST">
                        <p id="message"></p>
                        <input type="text" name="id" id="id" value="" hidden>
                        <p id="message"></p>
                        <div id="emailFormGroup" class="form-group">
                            <label class=" control-label" for="email">Email</label>
                            <input type="text" class="form-control" id="email" name="email">
                            <small class="email_error_text text-danger"></small>
                        </div>

                        <div class="form-group">
                            <label for="password">Roles</label>
                            <div class="form-check">
                                <div id="superGroup">
                                    <input class="form-check-input" name="role_super_admin" value="ROLE_SUPER_ADMIN" type="checkbox" id="ROLE_SUPER_ADMIN">
                                    <span class="form-check-label" for="role_super_admin">
                                        Super Admin
                                    </span>
                                </div>
                                <div id="adminGroup">
                                    <input class="form-check-input" name="role_admin" value="ROLE_ADMIN" type="checkbox" id="ROLE_ADMIN">
                                    <span class="form-check-label" for="role_admin">
                                        Admin
                                    </span>
                                </div>
                                <div id="userGroup">
                                    <input class="form-check-input" name="role_user" value="ROLE_USER" type="checkbox" id="ROLE_USER">
                                    <span class="form-check-label" for="role_user">
                                        User
                                    </span>
                                </div>

                            </div>

                            <div id="passwordFormGroup" class="form-group">

                                <label for="password">Contraseña</label>
                                <input type="text" class="form-control " name="password" id="password" placeholder="">
                                <small class="password_error_text text-danger"></small>
                            </div>

                            <div id="nameFormGroup" class="form-group">
                                <label for="name">Nombre</label>
                                <input type="text" class="form-control " name="name" id="name" placeholder="">
                                <small class="name_error_text text-danger"></small>
                            </div>
                            <div id="lastnameFormGroup" class="form-group">
                                <label for="lastname">Apellido</label>
                                <input type="text" class="form-control " name="lastname" id="lastname" placeholder="">
                                <small class="lastname_error_text text-danger"></small>
                            </div>

                            <div id="telnumberFormGroup" class="form-group">
                                <label for="telnumber">Telefono</label>
                                <input type="text" class="form-control " name="telnumber" id="telnumber" placeholder="5555-5555">
                                <small class="telnumber_error_text text-danger"></small>
                            </div>
                            <div class="form-group ">
                                <div class="">
                                    <button type="submit" class="btn btn-primary">Guardar</button>
                                </div>
                            </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                </div>
            </div>

        </div>
    </div>