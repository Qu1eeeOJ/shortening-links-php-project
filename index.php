<?php
// Launch applications
$app = require 'app/bootstrap/bootstrap.php';

// Check if the get parameter
if (isset($_GET['r'])) {
    header("Location: ./refer.php?r=$_GET[r]");
}
?>

<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width,initial-scale=1,shrink-to-fit=no">
        <meta http-equiv="x-ua-compatible" content="ie=edge">

        <title><?=$app->conf->app['name'];?></title>

        <meta name="description" content="<?=$app->conf->app['name'];?>">
        <meta name="author" content="<?=$app->conf->app['author'];?>">
        <meta name="robots" content="noindex, nofollow">

        <!-- Stylesheets -->
        <link href="https://cdn.jsdelivr.net/npm/tailwindcss@1.5.1/dist/tailwind.min.css" rel="stylesheet">
    </head>

    <body>
        <!-- APP -->
        <div id="app">
            <!-- Page Container -->
            <div class="min-h-screen flex items-center justify-center bg-gray-100 text-gray-900 relative">
                <!-- Waves Background -->
                <div class="absolute right-0 bottom-0 left-0">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -100 1440 320">
                        <path fill="#EDF2F7" fill-opacity="1"
                              d="M0,96L26.7,112C53.3,128,107,160,160,181.3C213.3,203,267,213,320,192C373.3,171,427,117,480,122.7C533.3,128,587,192,640,229.3C693.3,267,747,277,800,245.3C853.3,213,907,139,960,138.7C1013.3,139,1067,213,1120,224C1173.3,235,1227,181,1280,154.7C1333.3,128,1387,128,1413,128L1440,128L1440,320L1413.3,320C1386.7,320,1333,320,1280,320C1226.7,320,1173,320,1120,320C1066.7,320,1013,320,960,320C906.7,320,853,320,800,320C746.7,320,693,320,640,320C586.7,320,533,320,480,320C426.7,320,373,320,320,320C266.7,320,213,320,160,320C106.7,320,53,320,27,320L0,320Z"></path>
                    </svg>
                </div>
                <!-- END Waves Background -->

                <!-- Log In Section -->
                <div class="px-5 py-6 lg:px-6 lg:py-8 w-full md:w-8/12 lg:w-6/12 xl:w-4/12 relative">
                    <!-- Logo -->
                    <div class="mb-6 text-center">
                        <h3 class="text-3xl inline-flex items-center">
                            <svg class="w-6 h-6 inline-block text-indigo-500 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                        d="M4 2a2 2 0 00-2 2v11a3 3 0 106 0V4a2 2 0 00-2-2H4zm1 14a1 1 0 100-2 1 1 0 000 2zm5-1.757l4.9-4.9a2 2 0 000-2.828L13.485 5.1a2 2 0 00-2.828 0L10 5.757v8.486zM16 18H9.071l6-6H16a2 2 0 012 2v2a2 2 0 01-2 2z"
                                        clip-rule="evenodd" fill-rule="evenodd"></path>
                            </svg>
                            Web Application - <?=$app->conf->app['name'];?>
                        </h3>
                        <p class="text-gray-600">
                            Welcome, enter the link you want to shorten
                        </p>
                    </div>
                    <!-- END Logo -->

                    <!-- Form -->
                    <div class="rounded border p-6 lg:p-10 shadow-sm bg-white">
                        <form @submit.prevent="generateShortUrl" method="post" action="/registerUrl.php">
                            <label class="block text-gray-700">Url
                                <input v-model="fullUrl" type="url" name="url"  class="appearance-none border rounded px-4 py-3 mt-1 block w-full outline-none focus:border-blue-500" placeholder="Enter your url">
                            </label>

                            <br>

                            <label v-if="url != null" class="block text-gray-700">Short url
                                <input type="text" class="appearance-none border rounded px-4 py-3 mt-1 block w-full outline-none focus:border-blue-500" :value="url" disabled>
                            </label>

                            <div class="mt-6">
                                <button :class="{ 'opacity-50': loading, 'cursor-not-allowed': loading }"
                                        :disabled="loading"
                                        class="px-4 py-3 bg-blue-500 text-white rounded hover:bg-blue-700 focus:outline-none focus:shadow-outline block w-full">
                                    Shorten
                                </button>
                            </div>
                        </form>
                    </div>
                    <!-- END Form -->

                    <!-- Footer -->
                    <div class="text-xs text-gray-600 text-center mt-6">
                        <span class="font-semibold">Version - <?=$app->conf->app['version'];?></span> &copy;
                        {{ date }}
                    </div>
                    <!-- END Footer -->
                </div>
                <!-- END Log In Section -->
            </div>
            <!-- END Page Container -->
        </div>
        <!-- END APP -->

        <!-- VueJS -->
        <script src="https://cdn.jsdelivr.net/npm/vue@2.6.11"></script>
        <script src="https://cdn.jsdelivr.net/npm/axios@0.19.2/dist/axios.min.js"></script>
        <script>
            var app = new Vue({
                el: '#app',
                data() {
                    return {
                        fullUrl: null,
                        url: null,
                        lastUrl: null,
                        loading: false,
                        waiting: false,
                        date: (new Date).getFullYear(),
                    }
                },
                methods: {
                    generateShortUrl() {
                        if (!this.waiting) {
                            this.loading = true;
                            this.waiting = true;
                            if (this.fullUrl.length > 0) {
                                let fullUrl = this.fullUrl.trim();
                                if (fullUrl.toUpperCase() !== this.lastUrl) {
                                    axios.post('/registerUrl.php', { url: fullUrl }).then(response => {
                                        console.log(response.data.message);
                                        if (response.data.type === 'success') {
                                            this.lastUrl = fullUrl.toUpperCase();
                                        }
                                        this.url = response.data.redirect_from;
                                    }).catch(error => {
                                        alert('An error occurred, please try again later');
                                    });
                                } else {
                                    alert("You just used this address for shortening");
                                }
                            } else {
                                alert('The void is not a link...');
                            }
                            this.loading = false;
                            this.waiting = false;
                        } else {
                            alert('You have already sent a request!');
                        }
                    }
                }
            });
        </script>
    </body>
</html>
