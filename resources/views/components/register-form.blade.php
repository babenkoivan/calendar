<section class="section is-large" v-if="!user.authenticated() && user.invitation_token">
    <div class="container">
        <c-form action="/auth/register" type="post" class="auth-form" :success="initUser">
            <c-input type="hidden" name="invitation_token" :preset="user.invitation_token"></c-input>

            <div class="field">
                <label class="label">Enter new password</label>
                <p class="control">
                    <c-input type="password" name="password"></c-input>
                </p>
            </div>

            <div class="field buttons">
                <p class="control">
                    <c-submit-button class="button is-primary">Register</c-submit-button>
                </p>
            </div>
        </c-form>
    </div>
</section>