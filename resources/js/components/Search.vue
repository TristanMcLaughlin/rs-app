<template>
    <div v-if="!player">
        <p>Search for a player</p>
        <input v-model="search" v-on:keyup.enter="doSearch" placeholder="Player name">
        <button @click="doSearch">Search</button>
        <ul v-if="errors">
            <li v-for="error in errors">
                {{error.join(', ')}}
            </li>
        </ul>
    </div>
    <div v-else>
        <h1>{{ search }}</h1>
        <h3>Combat level: {{player.combat}}</h3>

        <div v-for="activity in player.activities">
            <p>
                <strong>
                    {{activity.name}} 
                    <small>{{activity.date}}</small>
                </strong>
                <br>
                {{activity.details}}
            </p>
        </div>
        <button class="close" @click="resetPlayer">Back to main</button>
    </div>
</template>
<script>
export default {
    data () {
        return {
            search: '',
            player: null,
            activity: null,
            errors: null
        }
    },
    methods: {
        resetPlayer() {
            this.player = null;
        },
        doSearch () {
            var vm = this;

            axios.post('/api/search', {
                search: this.search,
            })
            .then(response => {
                vm.player = response.data;
            })
            .catch(error => {
                vm.errors = error.response.data.errors;
            });
        }
    }
}
</script>