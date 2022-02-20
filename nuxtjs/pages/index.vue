<template>
    <div>
        <el-input
            v-model="nome"
            placeholder=""
            size="normal"
            clearable
        ></el-input>
        <el-input
            v-model="senha"
            placeholder=""
            size="normal"
            clearable
        ></el-input>
        <el-button type="primary" size="default" @click="entrar"
            >Entrar</el-button
        >
    </div>
</template>

<script>
export default {
    name: "IndexPage",
    data() {
        return {
            nome: "",
            senha: "",
        };
    },
    methods: {
        async entrar() {

            // this.$auth.login()
            var response = await this.$auth.loginWith("local", {
                data: {
                    nome: this.nome,
                    senha: this.senha,
                },
            });
            // debugger;
        },
    },
};
</script>
