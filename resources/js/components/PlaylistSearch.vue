<template>
    <div>

        <!-- todo optional PlaylistId / Spotify URI -->
        <div class="input-group">
            <input class="form-input" id="playlist-input" placeholder="Playlist" type="text">
            <button class="input-group-addon" type="submit" v-on:click="fetchPlaylists()">Submit</button>
        </div>

        <div class="container hidden" id="result-container">
            <div class="result columns" v-for="playlist of playlists">
                <!-- todo if URl empty -->
                <div class="col-auto"><img alt="Playlist title image" v-bind:src="playlist.mainImageURL"></div>
                <div class="col-auto"><p><b>{{ playlist.name }}</b> <br> {{ playlist.owner }}</p></div>
                <div class="col-ml-auto">
                    <form action="/playlist" class="text-center input-group" method="POST">
                        <input name="_token" type="hidden" v-bind:value="csrf">
                        <input name="nachricht" type="hidden" v-bind:value=" JSON.stringify(playlist)">
                        <input class="input-group-addon" type="submit" value="Abschicken">
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
    methods: {
        fetchPlaylists() {
            let formInput = document.getElementById("playlist-input");
            const input = formInput.value;

            this.fetch(input);
            formInput.value = "";
        },
        fetch(query) {
            fetch("api/searchPlaylist/" + query)
                .then(res => res.json())
                .then(res => {
                    this.playlists = res;
                    document.getElementById('result-container').className = 'container shown'
                })
                .catch(error => {
                    console.log('error', error);
                    document.getElementById('result-container').className = 'container shown';
                    document.getElementById('result-container').innerHTML = "<h3>Sorry, no playlist found!</h3>";
                });
        }
    }
}
</script>
