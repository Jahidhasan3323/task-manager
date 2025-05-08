<script setup>
    import useStore from "@/store/store.js";
    import {useRouter} from "vue-router";

    const store = useStore();
    const router = useRouter();

    const logout = () => {
        store.logout();
        router.push('/login');
    }
</script>
<template>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Task Manager</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <div class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <button v-if="store.getToken" class="btn btn-outline-danger me-2" type="button" @click="logout">
                        Logout
                    </button>
                </div>

            </div>
        </div>
    </nav>
    <div class="container mt-5">
        <router-view></router-view>
    </div>
</template>
