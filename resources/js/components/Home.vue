<template>
    <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <card-component titulo="Página Inicial">
                <template v-slot:conteudo>
                    <p class="text-justify">Seja muito bem vindo(a) a sua Agenda Telefônica Online</p>
                    <p class="text-justify">Aqui você pode salvar seus contatos de maneira simples e rápida.</p>
                    <p class="text-justify">Estamos na versão 1.0 de nossa agenda e você já pode:</p>
                    <ol>
                        <li>Criar contas de acesso ao sistema.</li>
                        <li>Cadastrar contatos, sendo possível inserir:</li>
                        <ul>
                            <li>Email</li>
                            <li>Endereço</li>
                            <li>Número de celular (em breve mais do que um número por contato)</li>
                        </ul>
                    </ol>
                    <p>Em breve traremos atualizações como:</p>
                    <ol>
                        <li>Permitir criar grupos para uma melhor divisão de seus contatos</li>
                        <li>Permitir compartilhar contatos com outros usuários(somente contatos que você selecionar).</li>
                    </ol>
                </template>
                <template v-slot:rodape>
                    
                </template>
            </card-component>
        </div>
    </div>
</div>
</template>

<script>

</script>