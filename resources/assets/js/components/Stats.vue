<template>
    <div class="col-md-12">
        <div class="form-group">
            <input type="text"
                   class="form-control"
                   v-model="filter.tags"
                   placeholder="Search by tag"
                   @input="searchWithFilter"
            >
            <input type="text"
                   class="form-control"
                   v-model="filter.aggregated_views"
                   placeholder="Search by performance"
                   @input="searchWithFilter"
            >
        </div>
        <div class="table-responsive">
            <table class="table table-striped table-bordered" style="width:100%">
                <thead width="400px">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Title</th>
                    <th scope="col">Tags</th>
                    <th scope="col">Performance</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(item, index) in data" :key="index">
                    <td>{{index + 1}}</td>
                    <td>{{item.title}}</td>
                    <td>{{item.tags}}</td>
                    <td>{{item.aggregated_views}}</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
    import axios from 'axios';
    import _ from 'lodash';

    export default {
        data: () => ({
            data: [
                {
                    title: '',
                    tags: '',
                    aggregated_views: 0,
                }
            ],
            filter: {
                tags: '',
                aggregated_views: '',
            },
        }),

        created() {
            this.initSearch();
        },

        methods: {
            initSearch() {
                axios.get('/api/youtube/stats', {
                    params: this.filter
                }).then(({data}) => {
                    this.data = data.data;
                });
            },

            searchWithFilter: _.debounce(function () {
                this.initSearch();
            }, 1000),
        },
    }
</script>
