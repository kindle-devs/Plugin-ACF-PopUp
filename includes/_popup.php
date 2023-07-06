<?php
$popups = get_field('popup', 'PopUp-settings');
$formato = 'd/m/Y H:i';
$hoje = new DateTime('now');


?>
<?php $exibindo = false; ?>
<?php if ($popups) : ?>
    <?php foreach ($popups  as $key => $popup) : ?>
        <?php

        $data_inicio_acf = $popup['data']['inicio'];
        $data_final_acf = $popup['data']['final'];

        $data_inicio =  DateTime::createFromFormat($formato, $data_inicio_acf . ' 00:00');
        $data_final  =  DateTime::createFromFormat($formato, $data_final_acf  . ' 23:59');

        if ($data_inicio_acf && $data_final_acf) {
            if ($hoje >= $data_inicio && $hoje <= $data_final) {
                $rangeDeDataCorreto = true;
            }
        } else if (!$data_inicio_acf || !$data_final_acf) {
            if (!$data_final_acf && $hoje >= $data_inicio) {
                $rangeDeDataCorreto = true;
            } else if (!$data_inicio_acf && $hoje <= $data_final) {
                $rangeDeDataCorreto = true;
            }
        } else {
            $rangeDeDataCorreto = false;
        }

        ?>

        <?php if ($rangeDeDataCorreto) : ?>
            <?php
            $apareceEmTodasAsPaginas = true
            ?>
            <?php if ($popup['configuracoes']['exibicao']) : ?>
                <?php
                $linksParaExibicao = [];
                $apareceEmTodasAsPaginas = false;
                ?>

                <?php foreach ($popup['configuracoes']['links'] as $key => $link) : ?>
                    <?php array_push($linksParaExibicao, url_to_postid($link['link']['url'])); ?>
                <?php endforeach; ?>

                <?php if (is_page($linksParaExibicao)) : ?>
                    <?php $apareceEmTodasAsPaginas = true; ?>
                <?php endif; ?>

            <?php endif; ?>

            <?php if (!$exibindo && $apareceEmTodasAsPaginas) : ?>
                <div id="popupPlugin" class="kindlePopup">
                    <?php $conteudo = $popup['infos']; ?>
                    <?php if ($conteudo['tipo_do_popup'] === 'imagem') :                ?>
                        <div class="kindlePopup__container">
                            <div class="kindlePopup__onlyImg kindlePopup__content">
                                <?php

                                $link = $conteudo['imagem']['link'];

                                if ($link) :
                                    $link_url = $link['url'];
                                    $link_title = $link['title'];
                                    $link_target = $link['target'] ? $link['target'] : '_self';
                                ?>
                                    <a class="" href="<?php echo esc_url($link_url); ?>" title="<?php echo esc_html($link_title); ?>" target="<?php echo esc_attr($link_target); ?>">
                                        <?php $img = $conteudo['imagem']['imagem'] ?>
                                        <img src='<?php echo $img['url'] ?>' alt='<?php echo $img['alt'] ?>'>
                                    </a>
                                <?php else : ?>
                                    <?php $img = $conteudo['imagem']['imagem'] ?>
                                    <img src='<?php echo $img['url'] ?>' alt='<?php echo $img['alt'] ?>'>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php else : ?>
                        <div class="kindlePopup__container">
                            <div class="kindlePopup__content">

                                <h3><?php echo $conteudo['criacao']['sobre_titulo'] ?> </h3>
                                <h2><?php echo $conteudo['criacao']['titulo'] ?></h2>
                                <?php echo $conteudo['criacao']['texto'] ?>

                                <?php

                                $link = $conteudo['criacao']['link'];

                                if ($link) :
                                    $link_url = $link['url'];
                                    $link_title = $link['title'];
                                    $link_target = $link['target'] ? $link['target'] : '_self';
                                ?>
                                    <a class="padrao-botao" href="<?php echo esc_url($link_url); ?>" target="<?php echo esc_attr($link_target); ?>"><?php echo esc_html($link_title); ?></a>
                                <?php endif; ?>

                            </div>
                        </div>
                    <?php endif; ?>

                    <?php

                    // echo '<br/> linha 9: <br/>';
                    // echo '<pre>';
                    // var_dump($popups);
                    // echo '</pre>';

                    ?>
                </div>

                <?php $exibindo = true; ?>
            <?php endif; ?>

        <?php endif; ?>
    <?php endforeach; ?>
<?php endif; ?>

<input id="exibir_popup" type="hidden" value="<?php the_field('exibir_popup', 'PopUp-settings'); ?>">
<input id="exibindo" type="hidden" value="<?php echo $exibindo ?>">