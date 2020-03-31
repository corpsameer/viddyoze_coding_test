<section class="login_part section_padding_20">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 col-md-6">
                    <div class="login_part_text text-center">
                        <div class="login_part_text_iner">
                            <h2>New to our Shop?</h2>
                            <p>Sign up now to get access to multiple widgets that matches your business requirements.</p>
                            <a href="/signup" class="btn_3">Create an Account</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="login_part_form">
                        <div class="login_part_form_iner">
                            <?php if ($response = $this->session->flashdata('response') ?? false) {
                              printf(
                                '<div class="alert alert-%s"><strong>%s %s! </strong>%s</div>',
                                $response['class'],
                                ($response['status'] == 'error') ? '<i class="fa fa-times-circle"></i>' : '<i class="fa fa-check-circle"></i>',
                                ucfirst($response['status']),
                                $response['message']
                              );
                            } ?>

                            <h3>Welcome Back ! <br>
                                Please Sign in now</h3>
                            <form class="row contact_form" action="/login/login" method="post">
                                <div class="col-md-12 form-group p_star">
                                    <input type="email" class="form-control" id="email" name="email" value=""
                                        placeholder="E-mail" required>
                                </div>
                                <div class="col-md-12 form-group p_star">
                                    <input type="password" class="form-control" id="password" name="password" value=""
                                        placeholder="Password" required>
                                </div>
                                <div class="col-md-12 form-group">
                                    <button type="submit" value="submit" class="btn_3">
                                        log in
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
