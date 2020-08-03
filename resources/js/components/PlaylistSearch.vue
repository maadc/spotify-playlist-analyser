<template>
    <div class="column col-12 col-mx-auto">
        <!-- todo support Playlist URL and Spotify URI -->
        <div class="container">
            <input class="form-input" id="playlist-input" placeholder="search for playlist name" type="text"
                   v-on:keyup.enter="fetchPlaylists">
            <button id="send" type="submit" v-on:click="fetchPlaylists()">
                <img alt="start search" src="../../img/arrow-right.svg" title="go!">
            </button>
        </div>

        <div class="container hidden" id="result-container">
            <div class="result columns mb-2" v-for="playlist of playlists">
                <!-- todo if URl empty -->
                <div class="col-sm-12 col-md-4 col-lg-4 col-xl-3 col-2"><img alt="Playlist title image"
                                                                             v-bind:src="playlist.mainImageURL"></div>
                <div class="col-sm-12 col-md-6 col-lg-6 col-xl-7 col-8"><p><b>{{ playlist.name }}</b> <br>
                    {{ playlist.owner }}
                </p></div>
                <div class="col-sm-12 col-lg-3 col-2">
                    <form action="/playlist" class="text-center input-group" method="POST">
                        <input name="_token" type="hidden" v-bind:value="csrf">
                        <input name="nachricht" type="hidden" v-bind:value=" JSON.stringify(playlist)">
                        <input class="input-group-addon" type="submit" value="analyse">
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            playlists: [],
            csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    },
    props : ['url'],
    created() {
        console.log(this.url)
    },
    methods: {
        fetchPlaylists() {
            let formInput = document.getElementById("playlist-input");
            const input = formInput.value;
            if (input) {
                this.fetch(input);
                formInput.value = "";
            } else {

            }

        },
        fetch(query) {
            const requestOptions = {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ query: String(query) })
            };

            fetch(this.url, requestOptions)
                .then(res => res.json())
                .then(res => {
                    this.playlists = res;
                    document.getElementById('result-container').className = 'container shown'
                })
                .catch(error => {
                    console.log('error', error);
                    document.getElementById('result-container').className = 'container shown';
                    document.getElementById('result-container').innerHTML = "<h3>Sorry, no playlist found!</h3>";
                })
        }
    }
}
</script>
