<template>
    <div class="container-fluid" id="statistics-page">
        <div class="container columns">
            <div class="column col-sm-12 col-6" id="last-searched">
                <h3>Last searched</h3>
                <dl id="last">
                    <dd class="" v-for="playlist of this.list">
                        <form action="/playlist" class="text-center input-group" method="POST">
                            <input name="_token" type="hidden" v-bind:value="csrf">
                            <input name="playlist" type="hidden" v-bind:value=" JSON.stringify(playlist)">
                            <button class="input-group-addon c-hand" type="submit" value="analyse">
                                <div class="columns">
                                    <div class="column col-auto">
                                        <img alt="Spotify Playlist Image"
                                             title="Main image of { playlist.name }}"
                                             v-bind:src="playlist.mainImageURL">
                                    </div>
                                    <div class="column col-auto">
                                        <p class="text-left">
                                            <b>
                                                {{ playlist.name }}
                                            </b>
                                            <br>
                                            {{ playlist.owner }}
                                        </p>
                                    </div>
                                </div>
                            </button>
                        </form>
                    </dd>
                </dl>
            </div>
            <div class="column col-sm-12 col-6" id="most-searched">
                <h3>Top 10</h3>
                <dl id="top">
                    <dd class="" v-for="(playlist, index) of this.top">
                        <form action="/playlist" class="text-center input-group" method="POST">
                            <input name="_token" type="hidden" v-bind:value="csrf">
                            <input name="playlist" type="hidden" v-bind:value=" JSON.stringify(playlist)">
                            <button class="input-group-addon c-hand" type="submit" value="analyse">
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
                                    <div class="column col-auto">
                                        <p class="text-left">
                                            <b>
                                                {{ playlist.name }}
                                            </b>
                                            <br>
                                            {{ playlist.owner }}
                                        </p>
                                    </div>
                                    <div class="column col-auto col-ml-auto">
                                        <p class="text-left">
                                            <b>
                                                {{ playlist.counter }}
                                            </b>
                                        </p>
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
    created() {
        console.log(this.list)
    },
    props: ['list', 'top'], //containing the last searchedPlaylists
    methods: {}
}
</script>
