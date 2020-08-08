<template>
    <div class="column col-xl-12 col-8 col-mx-auto">

        <div class="container shown mt-2" id="describtion-container">
            <p><b>Classify - the spotify playlist analyser - is here for you!</b><br>
                Gain a better insight into your spotify playlist of choice.
                Type the playlist name in the input field, press the button or hit enter. Classify searches
                through Spotify and returns up to 5 playlists which match to your typed name. The last step: Just click
                "analyse" to get the full insight in your playlist! Have fun!</p>
        </div>

        <div class="container">
            <input class="form-input"
                   id="playlist-input"
                   placeholder="search for playlist name, or paste an url/uri" type="text"
                   v-on:keyup.enter="fetchPlaylists">
            <button id="send" type="submit" v-on:click="fetchPlaylists()">
                <img alt="start search" src="../../img/arrow-right.svg" title="go!">
            </button>
        </div>

        <!--
            The results of the playlist-search
            todo: handle if any field are empty
        -->

        <div class="container hidden" id="result-container">
            <dl>
                <dd class="result columns mb-2" v-for="playlist of playlists">
                    <!--
                    Form for triggering the TrackController and redirect to /playlist for the analysis
                     -->
                    <form action="/playlist" class="text-center input-group" method="POST">
                        <input name="_token" type="hidden" v-bind:value="csrf">
                        <input name="playlist" type="hidden" v-bind:value=" JSON.stringify(playlist)">
                        <button class="c-hand list" type="submit" value="analyse">

                            <div class="columns">
                                <div class="column col-xs-12 col-xs-mx-auto col-auto">
                                    <img alt="Playlist title image" v-bind:src="playlist.mainImageURL">
                                </div>
                                <div class="column col-xs-12 col-xs-mx-auto col-auto text-left">
                                    <p class=" text-bold" v-text="playlist.name"></p>
                                    <p v-text="playlist.owner"></p>
                                </div>
                            </div>
                        </button>
                    </form>

                </dd>
            </dl>
        </div>
        <div class="container hidden mt-2" id="fail-container">
            <h3>Sorry, no playlist found!</h3>
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
    props: ['url'], //containing the signed fetchURL
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
                headers: {"Content-Type": "application/json"},
                body: JSON.stringify({query: String(query)})
            };

            fetch(this.url, requestOptions)
                .then(res => res.json())
                .then(res => {
                    this.playlists = res;
                    document.getElementById('fail-container').className = 'container hidden';
                    document.getElementById('result-container').className = 'container shown'
                })
                .catch(error => {
                    console.log('error', error);
                    document.getElementById('result-container').className = 'container hidden'
                    document.getElementById('fail-container').className = 'container shown';
                })
        }
    }
}
</script>
