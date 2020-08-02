<template>
    <div>

        <!-- input group with button -->
        <div class="input-group">
            <input id="playlist-input" type="text" class="form-input" placeholder="Playlist">
            <button class="input-group-addon" type="submit" v-on:click="fetchPlaylists()">Submit</button>
        </div>

        <div id="result-container" class="container hidden">

            <div class="result columns">
                <div class="col-auto"><img v-bind:src="playlist.mainImageURL" alt="Playlist title image"></div>
                <div class="col-auto"><p><b>{{ playlist.name }}</b> <br> {{ playlist.owner }}</p></div>
                <div class="col-ml-auto">
                    <form class="text-center input-group" action="/playlist" method="POST">
                        <input type="hidden" name="_token" v-bind:value="csrf">
                        <input type="hidden" name="nachricht" v-bind:value="playlist.spotifyID">
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
            playlist: [],
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
                    console.log(res)
                    this.playlist = res;
                    document.getElementById('result-container').className = 'container shown'
                })
                .catch(error => console.log('error', error));
        }
    }
}
</script>
