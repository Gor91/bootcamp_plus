<header class="header">
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="/"><?= strtoupper($this->params['bootcamp_name']) ?></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup"
                    aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav">
                    <div class="header__list"><a href="#about" class="nav-item nav-link header__link">METHODOLOGY</a>
                    </div>
                    <?php if ((!empty($this->params['is_agenda']))) : ?>
                        <div class="header__list"><a href="#agenda" class="nav-item nav-link header__link">Agenda</a>
                        </div>
                    <?php endif; ?>
                    <?php if (!empty($this->params['is_mentors_or_speakers'])) : ?>
                        <div class="header__list"><a href="#mentors" class="nav-item nav-link header__link">Mentors</a>
                        </div>
                    <?php endif; ?>
                    <?php if ((!empty($this->params['is_participants']))) : ?>
                        <div class="header__list"><a href="#participants" class="nav-item nav-link header__link">Participants</a>
                        </div>
                    <?php endif; ?>
                    <?php if (!empty($this->params['is_learning'])): ?>
                        <div class="header__list"><a href="#learning" class="nav-item nav-link header__link">Program</a>
                        </div>
                    <?php endif; ?>
                    <div class="header__list"><a href="#contact" class="nav-item nav-link header__link">Contacts</a>
                    </div>
                </div>
            </div>
        </nav>
    </div>
</header>