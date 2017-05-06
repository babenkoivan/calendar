<section class="section is-large" v-if="!user.authenticated()">
    <div class="container">
        <c-form action="/auth" type="post" class="auth-form" :success="initUser">
            <div class="field">
                <label class="label">Email</label>
                <p class="control">
                    <c-input type="email" name="email" />
                </p>
            </div>

            <div class="field">
                <label class="label">Password</label>
                <p class="control">
                    <c-input type="password" name="password" />
                </p>
            </div>

            <div class="field">
                <p class="control">
                    <c-submit-button class="button is-primary">Submit</c-submit-button>
                </p>
            </div>
        </c-form>
    </div>
</section>