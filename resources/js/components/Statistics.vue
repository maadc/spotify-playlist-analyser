<template>
    <div class="container-fluid" id="statistics-page">
        <div class="container columns">
            <div class="column col-md-12 col-6" id="last-searched">
                <h3>Last searched</h3>
                <dl id="last">
                    <dd class="" v-for="playlist of this.list">
                        <form action="/playlist" class="text-center input-group" method="POST">
                            <input name="_token" type="hidden" v-bind:value="csrf">
                            <input name="playlist" type="hidden" v-bind:value=" JSON.stringify(playlist)">
                            <button class="list c-hand" type="submit" value="analyse">
                                <div class="columns">
                                    <div class="column col-auto">
                                        <img alt="Spotify Playlist Image"
                                             v-bind:title=" 'Main playlist image of' + playlist.name "
                                             v-bind:src="playlist.mainImageURL">
                                    </div>
                                    <div class="column col-8 text-left">
                                        <p class=" text-bold" v-text="playlist.name"></p>
                                        <p v-text="playlist.owner"></p>
                                    </div>
                                </div>
                            </button>
                        </form>
                    </dd>
                </dl>
            </div>
            <div class="column col-md-12 col-6" id="most-searched">
                <h3>Top 10</h3>
                <dl id="top">
                    <dd class="" v-for="(playlist, index) of this.top">
                        <form action="/playlist" class="text-center input-group" method="POST">
                            <input name="_token" type="hidden" v-bind:value="csrf">
                            <input name="playlist" type="hidden" v-bind:value=" JSON.stringify(playlist)">
                            <button class="c-hand list" type="submit" value="analyse">
                                <div class="columns">
                                    <div class="column col-auto">
                                        <span>
                                            {{ index + 1 }}
                                        </span>
                                    </div>
                                    <div class="column col-auto">
                                        <img alt="Spotify Playlist Image"
                                             title="Main image of { playlist.name }}"
                                             v-bind:src="playlist.mainImageURL">
                                    </div>
                                    <div class="column col-6 text-left">
                                        <p class=" text-bold" v-text="playlist.name"></p>
                                        <p v-text="playlist.owner"></p>
                                    </div>
                                    <div class="column col-1 col-ml-auto">
                                        <p class=" text-bold" v-text="playlist.counter"></p>
                                    </div>
                                </div>
                            </button>
                        </form>
                    </dd>
                </dl>
            </div>
        </div>
    </div>
</template>

<script>
export default {

    data() {
        return {
            csrf: document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute('content')
        }
    },
    props: ['list', 'top'], //containing the last searchedPlaylists
    methods: {}
}
</script>
