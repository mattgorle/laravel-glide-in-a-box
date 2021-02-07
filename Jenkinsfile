pipeline {
  agent any
  stages {
    stage('Checkout') {
      steps {
        git(url: 'https://github.com/mattgorle/laravel-glide-in-a-box', branch: 'dev')
      }
    }

    stage('Test') {
      parallel {
        stage('PHP 7.3') {
          agent {
            docker {
              image 'mattgorle/php73:latest'
              args '-u root'
            }

          }
          steps {
            echo 'Running PHP 7.3 tests...'
            sh 'php -v'
            echo 'Installing Composer'
            sh 'curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer'
            echo 'Installing project composer dependencies...'
            sh 'cd $WORKSPACE && composer install --no-progress'
            echo 'Running PHPUnit tests...'
            sh 'php $WORKSPACE/vendor/bin/phpunit --coverage-html $WORKSPACE/report/clover --coverage-clover $WORKSPACE/report/clover.xml --log-junit $WORKSPACE/report/junit.xml'
            sh 'chmod -R a+w $PWD && chmod -R a+w $WORKSPACE'
            junit 'report/*.xml'
          }
        }

        stage('PHP 7.4') {
          agent {
            docker {
              image 'mattgorle/php74:latest'
              args '-u root'
            }

          }
          steps {
            echo 'Running PHP 7.4 tests...'
            sh 'php -v'
            echo 'Installing Composer'
            sh 'curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer'
            echo 'Installing project composer dependencies...'
            sh 'cd $WORKSPACE && composer install --no-progress'
            echo 'Running PHPUnit tests...'
            sh 'php $WORKSPACE/vendor/bin/phpunit --coverage-html $WORKSPACE/report/clover --coverage-clover $WORKSPACE/report/clover.xml --log-junit $WORKSPACE/report/junit.xml'
            sh 'chmod -R a+w $PWD && chmod -R a+w $WORKSPACE'
            junit 'report/*.xml'
          }
        }

        stage('PHP 8.0') {
          agent {
            docker {
              image 'mattgorle/php80:latest'
              args '-u root'
            }

          }
          steps {
            echo 'Running PHP 8.0 tests...'
            sh 'php -v'
            echo 'Installing Composer'
            sh 'curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer'
            echo 'Installing project composer dependencies...'
            sh 'cd $WORKSPACE && composer install --no-progress'
            echo 'Running PHPUnit tests...'
            sh 'php $WORKSPACE/vendor/bin/phpunit --coverage-html $WORKSPACE/report/clover --coverage-clover $WORKSPACE/report/clover.xml --log-junit $WORKSPACE/report/junit.xml'
            sh 'chmod -R a+w $PWD && chmod -R a+w $WORKSPACE'
            junit 'report/*.xml'
          }
        }

      }
    }

    stage('Release') {
      steps {
        echo 'Ready to release etc.'
      }
    }

  }

  post {
    always {
      echo 'Fixing permissions of all generated files...'
      sh 'chown -R jenkins:jenkins $WORKSPACE'
    }
  }
}
