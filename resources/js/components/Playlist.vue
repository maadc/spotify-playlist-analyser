<template>
    <div class="mt-2">
        <div class="dropdown">
            <a class="dropdown-toggle" href="#" tabindex="0">
                <img alt="show/hide columns" src="../../img/eye.svg" title="show/hide columns">
            </a>
            <ul class="menu form-group">
                <div class="switches" v-for="(column, index) of this.options.columns">
                    <label class="form-switch">
                        <input type="checkbox"
                               v-bind:checked="column.visible"
                               v-bind:id="[index]"
                               v-on:click="hide(index, undefined)">
                        <i class="form-icon"></i>
                        {{ column.title }}
                    </label>
                    <div class="second-switches">
                        <label class="form-switch" v-for="(columnSecond, indexSecond) of column.columns">
                            <input type="checkbox"
                                   v-bind:checked="columnSecond.visible"
                                   v-bind:id="'['+ index +']'+'.'+'[' + indexSecond+ ']'"
                                   v-on:click="hide(index, indexSecond)">
                            <i class="form-icon"></i>
                            {{ columnSecond.title }}
                        </label>
                    </div>
                </div>
            </ul>
        </div>

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
                height: "calc(100vh - 1.5rem - 76px - 82px - 48px - 48px)",
                width: "100%",
                layout: "fitData",
                frozen: true,
                initialSort: [             //set the initial sort order of the data
                    {column: "name", dir: "asc"},
                ],
                columns: [
                    {
                    title:"Play",field: "url",  headerSort:false, visible: true,
                        formatter: (cell) => {
                            return "<a href='" + cell.getValue() + "' target='_blank'>" +
                                "<img src='/images/play.svg'></a>";
                        }
                    },
                    {title: "Name", field: "name", width: 150, visible: true,},
                    {title: "Name", field: "name", width: 230, visible: true,},
                    {title: "Artist", field: "artists", visible: true, width: 230},
                    {title: "Duration", field: "duration", visible: true},
                    {title: "Popularity", field: "popularity", visible: true, topCalc: "avg"},
                    {title: "Key", field: "audioFeatures.key", visible: true, topCalc: "avg"},
                    {title: "BPM", field: "audioFeatures.tempo", visible: true, topCalc: "avg"},
                    {
                        title: "Audio Features",
                        visible: true,
                        columns: [
                            {title: "acousticness", field: "audioFeatures.acousticness", visible: true, topCalc: "avg"},
                            {title: "danceability", field: "audioFeatures.danceability", visible: true, topCalc: "avg"},
                            {title: "energy", field: "audioFeatures.energy", visible: true, topCalc: "avg"},
                            {
                                title: "instrumentalness",
                                field: "audioFeatures.instrumentalness",
                                visible: true,
                                topCalc: "avg"
                            },
                            {title: "liveness", field: "audioFeatures.liveness", visible: true, topCalc: "avg"},
                            {title: "loudness", field: "audioFeatures.loudness", visible: true, topCalc: "avg"},
                            {title: "speechiness", field: "audioFeatures.speechiness", visible: true, topCalc: "avg"},
                            {title: "valence", field: "audioFeatures.valence", visible: true, topCalc: "avg"}
                        ]
                    }
                ],
            }
        }
    },
    props: ['playlist'], //containing the signed fetchURL
    created() {
    },
    methods: {
        hide(index, indexSecond) {
            if (indexSecond === undefined) {

                const checked = document.getElementById(index).checked;

                if (this.options.columns[index].columns !== undefined) {
                    this.options.columns[index].columns.forEach((ele, eleindex) => {
                        document.getElementById('[' + index + '].[' + String(eleindex) + ']').checked = checked;
                        ele.visible = checked;
                    })
                }
                this.options.columns[index].visible = checked;
            } else {
                const checked = document.getElementById('[' + index + ']' + '.' + '[' + indexSecond + ']').checked;
                this.options.columns[index].columns[indexSecond].visible = checked;
            }
        }
    }
}
</script>
