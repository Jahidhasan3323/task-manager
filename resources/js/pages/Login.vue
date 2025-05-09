<script setup>
import {useStore} from "@/store/store.js";
import {ref} from "vue";
import {useRouter} from "vue-router";

const store = useStore()
const router = useRouter()

const form = ref({
    email: '',
    password: ''
});
const errors = ref();
const login = () => {
    axios.post('/login', form.value)
        .then(response => {
            const res = response.data.data;
        if (res.token) {
            store.setToken(res.token);
            store.setUser(res.user);
            Toast.fire({icon: 'success', title: response.data.message })
            router.push('/');
        }
    })
        .catch((error) => {
            const res = error.response.data;
            if (error.response.status == 422) {
                errors.value = res.errors
            } else {
                errors.value=null
                Toast.fire({icon: 'error', title: res.data.error })
            }
        })
}
</script>

<template>
    <div class="row">
        <div class="col-md-4 offset-4 ">
            <div class="card">
                <div class="card-body text-bg-light border-0">
                    <form @submit.prevent="login">
                        <div class="mb-3">
                            <label for="name" class="form-label">Email</label>
                            <input type="email" class="form-control" id="name" placeholder="name@example.com" v-model="form.email">
                            <span v-if="errors?.email" class="text-danger" v-for="error in errors.email">{{error}}</span>

                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" placeholder="password" v-model="form.password">
                            <span v-if="errors?.password" class="text-danger" v-for="error in errors.password">{{error}}</span>
                        </div>
                        <div class="mb-3">
                            <button type="submit" class="btn btn-success">Login</button>
                        </div>
                    </form>
                </div>

            </div>

        </div>
    </div>
</template>

<style scoped>

</style>
