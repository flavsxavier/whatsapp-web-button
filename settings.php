<?php defined('ABSPATH') or die("Sem scripts kids, por favor."); ?>
<script>
    $(function() {
        $('#id__tel').mask('(99) 9999-9999');
    });
</script>
<style>
    .wpp__view_multi_numbers {
        position: absolute;
        display: block;
        right: 220px;
    }
</style>
<div class="wrap">
    <h1>Configurações do WhatsApp Web Button</h1>
    <form method="post" action="options.php" enctype="multipart/form-data">
        <?php settings_fields('settings__wwbtn_page'); ?>
        <?php do_settings_sections('settings__wwbtn_page'); ?>
        <div id="wwbtn__notices"></div>
        <div class="wpp__view_multi_numbers">
            <table>
                <tbody></tbody>
            </table>
        </div>
        <table class="form-table">
            <tbody>
                <tr>
                    <th scope="row">Ativar/Desativar Plugin</th>
                    <td>
                        <fieldset>
                            <label>
                                <input type="radio" name="wpp__active" id="wpp__active_activ" value="active" <?php checked(get_option('wpp__active'), 'active') ?> required>
                                <span>Ativado</span>
                            </label>
                            <br/>
                            <label>
                                <input type="radio" name="wpp__active" id="wpp__active_desactiv" value="desactive" <?php checked(get_option('wpp__active'), 'desactive') ?> required>
                                <span>Desativado</span>
                            </label>
                        </fieldset>
                    </td>
                </tr>
                <tr class="wpp__single_tel">
                    <th scope="row">
                        <label for="id__tel">Número</label>
                    </th>
                    <td>
                        <input type="text" name="wpp__telefone" id="id__tel" class="regular-text" value="<?php echo get_option('wpp__telefone'); ?>">
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="wpp__modes">Ícone</label>
                    </th>
                    <td>
                        <select name="wpp__img" id="wpp__modes">
                            <option value="wpp__padrao" <?php selected(get_option('wpp__img'), 'wpp__padrao'); ?>>Padrão</option>
                            <option value="wpp__business" <?php selected(get_option('wpp__img'), 'wpp__business'); ?>>Business</option>
                            <option value="wpp__custom" <?php selected(get_option('wpp__img'), "wpp__custom"); ?>>Personalizado</option>
                        </select>
                    </td>
                </tr>
                <tr class="wpp__img_custom hidden">
                    <th scope="row">
                        <label for="id__file">Imagem</label>
                    </th>
                    <td>
                        <input type="file" name="wpp__file" id="id__file" class="regular-text">
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="id__style">Posição Desktop</label>
                    </th>
                    <td>
                        <select name="wpp__style" id="id__style">
                            <option value="none" <?php selected(get_option('wpp__style'), "none"); ?>>Não Exibir</option>
                            <option value="right" <?php selected(get_option('wpp__style'), "right"); ?>>Direita</option>
                            <option value="left" <?php selected(get_option('wpp__style'), "left"); ?>>Esquerda</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="id__style_mb">Posição Mobile</label>
                    </th>
                    <td>
                        <select name="wpp__style_mb" id="id__style_mb">
                            <option value="none" <?php selected(get_option('wpp__style_mb'), "none"); ?>>Não Exibir</option>
                            <option value="top right" <?php selected(get_option('wpp__style_mb'), "top right"); ?>>Topo - Direita</option>
                            <option value="top left" <?php selected(get_option('wpp__style_mb'), "top left"); ?>>Topo - Esquerda</option>
                            <option value="bottom right" <?php selected(get_option('wpp__style_mb'), "bottom right"); ?>>Baixo - Direita</option>
                            <option value="bottom left" <?php selected(get_option('wpp__style_mb'), "bottom left"); ?>>Baixo - Esquerda</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="id__tooltip">Texto do Tooltip</label>
                    </th>
                    <td>
                        <input type="text" name="wpp__tooltip" id="id__tooltip" class="regular-text" value="<?php echo get_option('wpp__tooltip'); ?>"><br/><br/>
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="id__tooltip_pos">Posição do Texto</label>
                    </th>
                    <td>
                        <select name="wpp__tooltip_pos" id="id__tooltip_pos">
                            <option value="none" <?php selected(get_option('wpp__tooltip_pos'), "none"); ?>>Não Exibir</option>
                            <option value="top" <?php selected(get_option('wpp__tooltip_pos'), "top"); ?>>Topo</option>
                            <option value="right" <?php selected(get_option('wpp__tooltip_pos'), "right"); ?>>Direita</option>
                            <option value="bottom" <?php selected(get_option('wpp__tooltip_pos'), "bottom"); ?>>Baixo</option>
                            <option value="left" <?php selected(get_option('wpp__tooltip_pos'), "left"); ?>>Esquerda</option>
                        </select>
                        <p class="description">As opções relacionadas ao <strong>tooltip</strong> depende da utilização do <strong>Bootstrap</strong> ou qualquer framework que o utilize de forma semelhante.</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row">Múltiplos Números</th>
                    <td>
                        <fieldset>
                            <label>
                                <input type="radio" name="wpp__multi_act" id="wpp__multi_active" value="active" <?php checked(get_option('wpp__multi_act'), 'active'); ?>>
                                <span>Ativado</span>
                            </label>
                            <br/>
                            <label>
                                <input type="radio" name="wpp__multi_act" id="wpp__multi_desativ" value="desativ" <?php checked(get_option('wpp__multi_act'), 'desativ'); ?>>
                                <span>Desativado</span>
                            </label>
                        </fieldset>
                        <p class="description">A opção surtirá efeito abaixo <strong>apenas ao salvar</strong> as alterações, atenção.</p>
                    </td>
                </tr>
                <tr class="wpp__multi_tel">
                    <th scope="row">
                        <label for="id__multi_label">Texto da Opção</label>
                    </th>
                    <td>
                        <input type="text" name="wpp__multi_label_add" id="id__multi_label" class="regular-text">
                    </td>
                </tr>
                <tr class="wpp__multi_tel">
                    <th scope="row">
                        <label for="id__multi_number">Número</label>
                    </th>
                    <td>
                        <input type="text" name="wpp__multi_tele_add" id="id__multi_number" class="regular-text"> 
                    </td>
                </tr>
            </tbody>
        </table>
        <div id="table" class="table-editable">
            <table class="form-table">
                <tr>
                    <th>Nome</th>
                    <th>Número</th>
                    <th></th>
                </tr>
                <?php
                    $multi_numbers = get_option("opt__multi_numbers");
                    foreach ($multi_numbers as $key) {
                        echo "<tr>";
                        echo "<td>" . $key[0] . "</td>";
                        echo "<td>" . $key[1] . "</td>";
                        echo '<td><span class="table-remove"><i class="fa fa-trash" aria-hidden="true"></i></span></td>';
                        echo "</tr>";
                    }
                ?>
            </table>
        </div>
        <div class="wwbtn__submit">
            <p class="submit multi__n">
                <a href="#!" id="add__multi_btn" class="button button-secondary">Adicionar Telefone</a>
            </p>
        <?php submit_button(); ?>
        </div>
    </form>
</div>