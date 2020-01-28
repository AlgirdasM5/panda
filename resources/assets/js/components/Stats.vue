<template>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Example Component</div>
                    <div class="flex-center position-ref full-height">
                        <div class="content">
                            <div class="title m-b-md">
                                Dashboard
                            </div>

                            <div class="links">
                                Hello
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        I'm an example component!
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from 'axios';

    export default {
        mounted() {
            console.log('aa');

            axios.get('/api/youtube/stats', {
            }).then(response => {
                console.log(response);
            });
        }
    }
</script>
