module.exports = function(grunt) {
    
    // Initialize the grunt configuration
    grunt.initConfig({

        notify: {
            task_name: {
              options: {
                // Task-specific options go here.
              }
            },
            watch_css: {
              options: {
                title: 'Task Complete',
                message: 'CSS minified to public/css/main.css',
              }
            },
            watch_js: {
              options: {
                title: 'Task Complete',
                message: 'JS concatenated to public/js/main.js',
              }
            },
            server: {
              options: {
                title: 'Grunt Rocks!',
                message: 'Server is ready and waiting...'
              }
            },
            end: {
              options: {
                title: 'LR',
                message: 'ready and waiting...'
              }
            }
        },

        // less file compilation and compression
        less: {
            development: {
                options: {
                    compress: true
                },
                files: {  
                    './public/assets/css/frontend.css' : './app/assets/less/frontend.less',
                    './public/assets/css/backend.css'  : './app/assets/less/backend.less'
                }
            }
        },

        cssmin: {
          add_banner: {
            options: {
              banner: '/* Minified css  */'
            },
            files: {
                './public/css/main.css': 
                [
                    './app/assets/components/bower/bootstrap/dist/css/bootstrap.min.css',
                    './app/assets/components/bower/font-awesome/css/font-awesome.min.css',
                    './app/assets/css/theme/layout.css',
                    './app/assets/css/theme/components.css',
                    './app/assets/css/theme/plugins.css',
                    './app/assets/css/theme/custom.css',
                    './app/assets/css/theme/datepicker.css',
                    './app/assets/css/theme/theme.color.css',
                    './app/assets/css/theme/datepicker.custom.css',
                    './app/assets/components/bower/datatables/media/css/jquery.dataTables.css',
                    './app/assets/components/bower/toastr/toastr.css',
                    './app/assets/css/bootstrap-custom.css',
                    './app/assets/css/form.css',
                    './app/assets/css/table.css',
                    './app/assets/css/main.css',
                    './app/assets/css/autocomplete.css',
                    './app/assets/css/not-scroll.css',
                    './app/assets/css/compras.css',
                    './app/assets/css/master-detail.css',
                    './app/assets/css/producto.css',
                    './app/assets/css/proveedor.css',
                    './app/assets/css/categorias.css',
                    './app/assets/css/consultas.css',
                    './app/assets/css/cierre.css',
                    './app/assets/css/datepicker-pickadate-custom.css',
                    
                ],
                 './public/css/proveedor.css': 
                [
                    './app/assets/components/bower/bootstrap/dist/css/bootstrap.min.css',
                    './app/assets/components/bower/font-awesome/css/font-awesome.min.css',
                    './app/assets/css/theme/layout.css',
                    './app/assets/css/theme/components.css',
                    './app/assets/css/theme/plugins.css',
                    './app/assets/css/theme/custom.css',
                    './app/assets/css/theme/datepicker.css',
                    './app/assets/css/theme/theme.color.css',
                    './app/assets/css/theme/datepicker.custom.css',
                    './app/assets/components/bower/datatables/media/css/jquery.dataTables.css',
                    './app/assets/components/bower/toastr/toastr.css',
                    './app/assets/css/bootstrap-custom.css',
                    './app/assets/css/form.css',
                    './app/assets/css/table.css',
                    './app/assets/css/main.css',
                    './app/assets/css/autocomplete.css',
                    './app/assets/css/not-scroll.css',
                    './app/assets/css/consultas.css',
                    './app/assets/css/datepicker-pickadate-custom.css',
                    './app/assets/proveedor/css/*',
                    
                ],
                 './public/css/cliente.css': 
                [
                    './app/assets/components/bower/bootstrap/dist/css/bootstrap.min.css',
                    './app/assets/components/bower/font-awesome/css/font-awesome.min.css',
                    './app/assets/css/theme/layout.css',
                    './app/assets/css/theme/components.css',
                    './app/assets/css/theme/plugins.css',
                    './app/assets/css/theme/custom.css',
                    './app/assets/css/theme/datepicker.css',
                    './app/assets/css/theme/theme.color.css',
                    './app/assets/css/theme/datepicker.custom.css',
                    './app/assets/components/bower/datatables/media/css/jquery.dataTables.css',
                    './app/assets/components/bower/toastr/toastr.css',
                    './app/assets/css/bootstrap-custom.css',
                    './app/assets/css/form.css',
                    './app/assets/css/table.css',
                    './app/assets/css/main.css',
                    './app/assets/css/autocomplete.css',
                    './app/assets/css/not-scroll.css',
                    './app/assets/css/consultas.css',
                    './app/assets/css/datepicker-pickadate-custom.css',
                    './app/assets/css/cliente.css',
                    
                ]

            }
          }
        },
        // JS file concatenation
          concat: {
            options: {
              separator: ';',
            },
            dist: {
              src: [
                './app/assets/components/bower/jquery/jquery.js',
                './app/assets/js/jquery.cookie.js',
                './app/assets/components/bower/bootstrap/dist/js/bootstrap.js',
                './app/assets/components/bower/jquery-nicescroll/jquery.nicescroll.js',
                './app/assets/js/sparkline.min.js',
                './app/assets/js/jpreloader-v2/js/jpreloader.js',
                './app/assets/components/bower/jquery.easing/js/jquery.easing.js',
                './app/assets/js/apps.js',
                './app/assets/js/autocomplete.js',
                './app/assets/js/datepicker.js',
                './app/assets/components/bower/datatables/media/js/jquery.dataTables.js',
                './app/assets/components/bower/highcharts/highcharts.js',
                './app/assets/components/bower/highcharts/highcharts-3d.js',
                './app/assets/components/bower/highcharts/modules/exporting.js',
                './app/assets/components/bower/toastr/toastr.js',
                './app/assets/js/jquery.numeric.js',
                './app/assets/js/jquery_confirm.js',
                './app/assets/js/accounting.js',
                './app/assets/js/drilldown.js',
                './app/assets/js/barcode/barcode.js',
                './app/assets/js/barcode/jqprint.js',
              ],
              dest: './public/js/main.js',
            },

            custom: {
              src: [
                './app/assets/js/main.js',
                './app/assets/js/user.js',
                './app/assets/js/graph.js',
                './app/assets/js/ventas.js',
                './app/assets/js/compras.js',
                './app/assets/js/soporte.js',
                './app/assets/js/gastos.js',
                './app/assets/js/adelantos.js',
                './app/assets/js/egresos.js',
                './app/assets/js/ingresos.js',
                './app/assets/js/tables_queries.js',
                './app/assets/js/productos.js',
                './app/assets/js/proveedor.js',
                './app/assets/js/cliente.js',
                './app/assets/js/categorias.js',
                './app/assets/js/sub_categorias.js',
                './app/assets/js/marcas.js',
                './app/assets/js/data-remote.js',
                './app/assets/js/master-detail.js',
                './app/assets/js/consultas.js',
                './app/assets/js/cierre.js',
                './app/assets/js/codigobarras.js',
                './app/assets/js/usuario-consultas.js',
              ],
              dest: './public/js/custom.js'
            },
            proveedor: {
                src: [
                    './app/assets/js/main.js',
                    './app/assets/proveedor/js/*',
                  ],
                  dest: './public/js/proveedor.js'
                },
            cliente: {
                src: [
                    './app/assets/js/main.js',
                    './app/assets/js/ventas.js',
                    './app/assets/js/cliente.js',
                  ],
                  dest: './public/js/cliente.js'
                },
            },
          
        // copy ressources such as fonts, files, images, required by assets to the public directory
        copy : {
            fonts: {
                expand: true,
                cwd : './app/assets/components/bower/bootstrap/dist/fonts/',
                src: ['*'],
                dest: './public/fonts/'
            },
            js : {
                expand: true,
                cwd : './app/assets/components/bower/modernizr/',
                src: ['modernizr.js'],
                dest: './public/assets/js/'  
            }
        },

        // JS file obfuscation
        uglify: {
            dist: {
                files: {
                  './public/js/main.js'      : './public/js/main.js',
                  './public/js/custom.js'    : './public/js/custom.js',
                  './public/js/proveedor.js' : './public/js/proveedor.js',
                  './public/js/cliente.js'   : './public/js/cliente.js',
                }
            }
        },

        // run PHP unit tests
        phpunit: {
            classes: {
                dir: 'app/tests/'
            },
            options: {
                bin: 'vendor/bin/phpunit',
                colors: true
            }
        },

        // automatically run tasks when changing JS, LESS or PHP files
        watch: {
            js: {
                files: [
                './app/assets/js/*.*',
                './app/assets/proveedor/js/*.*',
                './app/assets/cliente/js/*.*'],
                tasks: ['concat', 'notify:end'],
                options: {
                    livereload: true,
                }
            },
            cssmin: {
                files: [
                './app/assets/css/**/*.css',
                './app/assets/proveedor/css/**/*.css',
                './app/assets/cliente/css/**/*.css'],
                tasks: ['cssmin'],
                options: {
                    livereload: true
                }
            },
            less: {
                files: ['./app/assets/less/*.*'],
                tasks: ['less', 'notify:watch'],
                options: {
                    livereload: true
                }
            },
            php: {
                files: [
                    'app/views/*.php'
                ],
                options: {
                    livereload: false
                }
            }      
        }
    });

    // Load grunt plugins
    grunt.loadNpmTasks('grunt-contrib-concat');
    grunt.loadNpmTasks('grunt-contrib-copy');
    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-contrib-cssmin');
    grunt.loadNpmTasks('grunt-contrib-less');
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-notify');
    grunt.loadNpmTasks('grunt-phpunit');

    grunt.registerTask('dev', ['cssmin', 'concat', 'notify:end', 'watch']);

    grunt.registerTask('build', ['cssmin', 'concat', 'uglify', 'copy', 'watch']);

};
