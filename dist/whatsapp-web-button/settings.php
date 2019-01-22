<?php defined('ABSPATH') or die("Sem scripts kids, por favor."); ?>
<div class="wrap">
    <h1>Configurações do WhatsApp Web Button</h1>
    <form method="post" action="options.php" enctype="multipart/form-data">
        <?php settings_fields('wwb__settings'); ?>
        <?php do_settings_sections('wwb__settings'); ?>
        <div id="wwb__notices"></div>
        <table class="form-table">
            <tbody>
                <tr>
                    <th scope="row">Manter WhatsApp Web Button</th>
                    <td>
                        <fieldset>
                            <label>
                                <input type="radio" name="wwb__status" id="wwb__status_act" value="activated" <?php checked(get_option('wwb__status'), 'activated') ?> required>
                                <span>Ativado</span>
                            </label>
                            <br/>
                            <label>
                                <input type="radio" name="wwb__status" id="wpp__status_dea" value="deactivated" <?php checked(get_option('wwb__status'), 'deactivated') ?> required>
                                <span>Desativado</span>
                            </label>
                        </fieldset>
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="wwb__modes">Ícone</label>
                    </th>
                    <td>
                        <select name="wwb__icon" id="wwb__modes">
                            <option value="wpp__padrao" <?php selected(get_option('wwb__icon'), 'wpp__padrao'); ?>>Padrão</option>
                            <option value="wpp__business" <?php selected(get_option('wwb__icon'), 'wpp__business'); ?>>Business</option>
                            <option value="wpp__custom" <?php selected(get_option('wwb__icon'), "wpp__custom"); ?>>Personalizado</option>
                        </select>
                    </td>
                </tr>
                <tr class="wwb__custom_icon hidden">
                    <th scope="row">
                        <label for="wwb__file_id">Ícone Customizado</label>
                    </th>
                    <td>
                        <input type="file" name="wwb__file" id="wwb__file_id" class="regular-text">
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="wwb__position_id">Posição em Dispositivos Desktop</label>
                    </th>
                    <td>
                        <select name="wwb__position" id="wwb__position_id">
                            <option value="none" <?php selected(get_option('wwb__position'), "none"); ?>>Não exibir nesses dispositivos</option>
                            <option value="right" <?php selected(get_option('wwb__position'), "right"); ?>>Direita</option>
                            <option value="left" <?php selected(get_option('wwb__position'), "left"); ?>>Esquerda</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="wwb__mbposition_id">Posição em Dispositivos Mobile</label>
                    </th>
                    <td>
                        <select name="wwb__mbposition" id="wwb__mbposition_id">
                            <option value="none" <?php selected(get_option('wwb__mbposition'), "none"); ?>>Não exibir nesses dispositivos</option>
                            <option value="right top" <?php selected(get_option('wwb__mbposition'), "right top"); ?>>Topo - Direita</option>
                            <option value="left top" <?php selected(get_option('wwb__mbposition'), "left top"); ?>>Topo - Esquerda</option>
                            <option value="bottom right" <?php selected(get_option('wwb__mbposition'), "bottom right"); ?>>Baixo - Direita</option>
                            <option value="bottom left" <?php selected(get_option('wwb__mbposition'), "bottom left"); ?>>Baixo - Esquerda</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for=" wwb__tooltip_id">Texto de Apresentação</label>
                    </th>
                    <td>
                        <input type="text" name="wwb__tooltip" id="wwb__tooltip_id" class="regular-text" value="<?php echo get_option('wwb__tooltip'); ?>"><br/><br/>
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="wwb__tooltip_pos_id">Posição do Texto</label>
                    </th>
                    <td>
                        <select name="wwb__tooltip_pos" id="wwb__tooltip_pos_id">
                            <option value="none" <?php selected(get_option('wwb__tooltip_pos'), "none"); ?>>Não Exibir</option>
                            <option value="top" <?php selected(get_option('wwb__tooltip_pos'), "top"); ?>>Topo</option>
                            <option value="right" <?php selected(get_option('wwb__tooltip_pos'), "right"); ?>>Direita</option>
                            <option value="bottom" <?php selected(get_option('wwb__tooltip_pos'), "bottom"); ?>>Baixo</option>
                            <option value="left" <?php selected(get_option('wwb__tooltip_pos'), "left"); ?>>Esquerda</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <p class="description"><strong>Aviso</strong></p>
                    </th>
                    <td><p class="description"><strong>Abaixo, você pode configurar apenas um número ou usar a opção "Múltiplos Números", ela vem desativada por padrão.</strong></p></td>
                </tr>
                <tr class="wwb__single_tel">
                    <th scope="row">
                        <label for="wwb__tel_id">Número</label>
                    </th>
                    <td>
                        <input type="text" name="wwb__telefone" id="wwb__tel_id" class="regular-text" value="<?php echo get_option('wwb__telefone'); ?>">
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <p class="description"><strong>Múltiplos Números</strong></p>
                    </th>
                    <td><p class="description"><strong>Permite configurar e usar vários números. Vem desativado por padrão.</strong></p></td>
                </tr>
                <tr>
                    <th scope="row">Usar Múltiplos Números</th>
                    <td>
                        <fieldset>
                            <label>
                                <input type="radio" name="wwb__multi_status" id="wpp__multi_stact" value="activated" <?php checked(get_option('wwb__multi_status'), 'activated'); ?>>
                                <span>Sim</span>
                            </label>
                            <br/>
                            <label>
                                <input type="radio" name="wwb__multi_status" id="wpp__multi_stdea" value="deactivated" <?php checked(get_option('wwb__multi_status'), 'deactivated'); ?>>
                                <span>Não</span>
                            </label>
                        </fieldset>
                        <p class="description">A opção surtirá efeito abaixo <strong>apenas ao salvar</strong> as alterações, atenção.</p>
                    </td>
                </tr>
                <tr class="wwb__multi_input hidden">
                    <th scope="row">
                        <label for="wwb__mlabel_id">Descrição/"Nome" do número</label>
                    </th>
                    <td>
                        <input type="text" name="wwb__multi_label" id="wwb__mlabel_id" class="regular-text" disabled>
                        <p class="description">A descrição, ou "nome", funciona como uma <strong>ID</strong>, portanto <strong>não</strong> pode haver "nomes" iguais.</p>
                    </td>
                </tr>
                <tr class="wwb__multi_input hidden">
                    <th scope="row">
                        <label for="wwb__mnumber_id">Número</label>
                    </th>
                    <td>
                        <input type="text" name="wwb__multi_tel" id="wwb__mnumber_id" class="regular-text" disabled> 
                        <p class="description">Salve as alterações <strong>após</strong> adicionar os números para que eles sejam registrados.</p>
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="wwbtn__submit hidden">
            <p class="submit multi__n">
                <a id="add__multi_btn" class="button button-secondary">Adicionar telefone</a>
            </p>
        </div>
        <?php if (get_option('wwb__multi_numbers')) : ?>
        <div id="wwbtn__table">
            <table id="table__multi_tel" class="display">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Número</th>
                        <th>  </th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $multi_numbers = get_option("wwb__multi_numbers");
                        foreach ($multi_numbers as $key) {
                            echo "<tr>";
                            echo "<td>" . $key[0] . "</td>";
                            echo "<td>" . $key[1] . "</td>";
                            echo "<td><a data-number='". $key[0] ."' class='delete__number'><span class='center'>delete</span></a></td>";
                            echo "</tr>";
                        }
                    ?>
                </tbody>
            </table>
        </div>
        <?php endif; ?>
        <?php submit_button(); ?>
    </form>
</div>