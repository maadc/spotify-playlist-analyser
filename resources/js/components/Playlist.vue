<template>
    <div class="mt-2">
        <Vue-Tabulator :options="options" v-model="playlist"/>
    </div>
</template>

<script>
import {TabulatorComponent} from "vue-tabulator";

export default {
    components: {
        'AwesomeLocalTable': TabulatorComponent
    },
    data() {
        return {
            options: {
                height:"calc(100vh - 1.5rem - 76px - 82px - 48px - 48px)",
                width:"100%",
                layout: "fitColumns",
                frozen: true,
                initialSort: [             //set the initial sort order of the data
                    {column: "name", dir: "asc"},
                ],
                columns: [
                    {title: "Name", field: "name", width: 230},
                    {title: "Artist", field: "artists", width: 230},
                    {title: "Duration", field: "duration", width: 100},
                    {title: "Popularity", field: "popularity", topCalc:"avg", width: 100},
                    {title: "Key", field: "audioFeatures.key", topCalc:"avg", width: 100},
                    {title: "BPM", field: "audioFeatures.tempo", topCalc:"avg", width: 100},
                    {
                        title: "Audio Features",
                        columns: [
                            {title: "acousticness", field: "audioFeatures.acousticness", topCalc:"avg"},
                            {title: "danceability", field: "audioFeatures.danceability", topCalc:"avg"},
                            {title: "energy", field: "audioFeatures.energy", topCalc:"avg"},
                            {title: "instrumentalness", field: "audioFeatures.instrumentalness", topCalc:"avg"},
                            {title: "liveness", field: "audioFeatures.liveness", topCalc:"avg"},
                            {title: "loudness", field: "audioFeatures.loudness", topCalc:"avg"},
                            {title: "speechiness", field: "audioFeatures.speechiness", topCalc:"avg"},
                            {title: "valence", field: "audioFeatures.valence", topCalc:"avg"}
                        ]
                    }
                ],
            }
        }
    },
    props: ['playlist'], //containing the signed fetchURL
    created() {
    },
    methods: {}
}
</script>
