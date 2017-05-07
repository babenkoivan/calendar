<section class="section is-large" v-if="!user.authenticated() && !user.invitation_token">
    <div class="container">
        <c-form action="/auth/login" type="post" class="auth-form" :success="initUser">
            <div class="field">
                <label class="label">Email</label>
                <p class="control">
                    <c-input type="email" name="email"></c-input>
                </p>
            </div>

            <div class="field">
                <label class="label">Password</label>
                <p class="control">
                    <c-input type="password" name="password"></c-input>
                </p>
            </div>

            <div class="field buttons">
                <p class="control">
                    <c-submit-button class="button is-primary">Submit</c-submit-button>
                </p>
            </div>
        </c-form>
    </div>
</section>