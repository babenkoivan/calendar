<nav class="nav has-shadow" v-if="user.authenticated()">
    <div class="container">
        <div class="nav-left is-hidden-mobile">
            <div class="nav-item" href="/">
                <i :class='["fa", "fa-calendar", {"is-danger": user.is_admin}]'></i>
            </div>

            <div class="nav-item">
                <span :class='{"is-danger": user.is_admin}'>@{{ user.name }}</span>'s Calendar
            </div>
        </div>

        <div class="nav-right">
            <div class="nav-item" v-if="user.is_admin">
                <div class="field">
                    <p class="control">
                        <button class="button is-primary" @click.prevent="mounted.get('modal.invitation').show()">
                            <i class="fa fa-envelope"></i>&nbsp;&nbsp;Send invitation
                        </button>
                    </p>
                </div>
            </div>

            <a class="nav-item" @click.prevent="logout()">Log out</a>
        </div>
    </div>
</nav>

<c-modal name="invitation">
    <h1 slot="title">Invitation</h1>

    <c-form action="/auth/invite" type="POST" :success="() => {mounted.get('modal.invitation').hide()}" name="invitation">
        <div class="field">
            <label class="label">Name</label>
            <p class="control">
                <c-input type="text" name="name"></c-input>
            </p>
        </div>

        <div class="field">
            <label class="label">Email</label>
            <p class="control">
                <c-input type="email" name="email"></c-input>
            </p>
        </div>

        <div class="field is-grouped">
            <p class="control">
                <c-submit-button class="button is-success">Send</c-submit-button>
            </p>

            <p class="control">
                <button class="button is-link" @click.prevent="mounted.get('modal.invitation').hide()">Cancel</button>
            </p>
        </div>
    </c-form>
</c-modal>