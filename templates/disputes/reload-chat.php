<?php
/**
 * Reload Dispute Chat
 * @since 1.0.0
 * @package Escrowtics
 */

$img_exts = ['jpg', 'jpeg', 'png', 'webp'];
$last_author = null; // Track the last processed author.
?>
<div class="p-5 messages text-dark">
    <ul>
        <?php foreach ($dispute_meta as $meta) : ?>
            <?php 
            $show_image = ($meta['author'] !== $last_author); // Show image only if the author changes.
            $last_author = $meta['author']; // Update the last author.
            ?>
            <?php if ($meta['author'] === 'Complainant' || $meta['author'] === 'Accused') : ?>
                <?php 
                if ($meta['author'] === 'Complainant') {
                    $user_img = escrot_single_user_meta($dispute_data['complainant'], 'user_image');
                    $user_name = esc_html($dispute_data['complainant']);
                    $li_class = "small";
                } else {
                    $user_img = escrot_single_user_meta($dispute_data['accused'], 'user_image');
                    $user_name = esc_html($dispute_data['accused']);
                    $li_class = "small escrot-accused-chat-box bg-dark";
                }
                ?>
                <li class="sent">
                    <?php if ($show_image) : ?>
                        <?= escrot_image($user_img, '50', 'escrot-rounded'); ?>
                    <?php else : ?>
                        <div style="width: 50px; height: 50px; display: inline-block;"></div>
                    <?php endif; ?>
                    <p class="<?= $li_class ?>">
                        <span class="small text-gray">
                            <i class="fa fa-user"></i> <?= ucwords($user_name) . ' (' . $meta['author'] . ')'; ?>
                        </span><br><br>
                        <?php if ($meta['meta_type'] === 'File') : ?>
                            <?php 
                            $file_name = basename($meta['meta_value']);
                            $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);
                            ?>
                            <?php if (in_array($file_ext, $img_exts, true)) : ?>
                                <img class="escrot-img-preview" src="<?= esc_url($meta['meta_value']); ?>" alt="<?= esc_attr($file_name); ?>"/><br>
                                <span>
                                    <a href="<?= esc_url($meta['meta_value']); ?>" target="_blank">View image</a>
                                </span>
                            <?php elseif ($file_ext === 'pdf') : ?>
                                <a href="<?= esc_url($meta['meta_value']); ?>" target="_blank">
                                    <?= escrot_image(ESCROT_PLUGIN_URL . 'assets/img/pdf-file-icon.png', '50', 'rounded-0') . esc_html($file_name); ?>
                                </a>
                            <?php else : ?>
                                <a href="<?= esc_url($meta['meta_value']); ?>" target="_blank">
                                    <?= escrot_image(ESCROT_PLUGIN_URL . 'assets/img/file-icon.png', '50', 'rounded-0') . esc_html($file_name); ?>
                                </a>
                            <?php endif; ?>
                        <?php else : ?>
                            <?= esc_html($meta['meta_value']); ?>
                        <?php endif; ?>
                        <br><br>
                        <span class="escrot-chat-date small small">
                            <i class="fa fa-clock"></i> <?= esc_html($meta['creation_date']); ?>
                        </span>
                    </p>
                </li>
            <?php else : ?>
                <li class="replies">
                    <?php if ($show_image) : ?>
                        <?= escrot_image(ESCROT_PLUGIN_URL . 'assets/img/escrowtics.png', '50', 'escrot-rounded'); ?>
                    <?php else : ?>
                        <div class="escrot-chat-noimage-indent" style="width: 50px; height: 50px; display: inline-block;"></div>
                    <?php endif; ?>
                    <p style="font-size: 13px !important;">
                        <span class="small text-gray float-right">
                            <i class="fa fa-user"></i> Admin
                        </span><br><br>
                        <?php if ($meta['meta_type'] === 'File') : ?>
                            <?php 
                            $file_name = basename($meta['meta_value']);
                            $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);
                            ?>
                            <?php if (in_array($file_ext, $img_exts, true)) : ?>
                                <img class="escrot-img-preview" src="<?= esc_url($meta['meta_value']); ?>" alt="<?= esc_attr($file_name); ?>"/><br>
                                <span>
                                    <a href="<?= esc_url($meta['meta_value']); ?>" target="_blank">View image</a>
                                </span>
                            <?php elseif ($file_ext === 'pdf') : ?>
                                <a href="<?= esc_url($meta['meta_value']); ?>" target="_blank">
                                    <?= escrot_image(ESCROT_PLUGIN_URL . 'assets/img/pdf-file-icon.png', '50', 'rounded-0') . esc_html($file_name); ?>
                                </a>
                            <?php else : ?>
                                <a href="<?= esc_url($meta['meta_value']); ?>" target="_blank">
                                    <?= escrot_image(ESCROT_PLUGIN_URL . 'assets/img/file-icon.png', '50', 'rounded-0') . esc_html($file_name); ?>
                                </a>
                            <?php endif; ?>
                        <?php else : ?>
                            <?= esc_html($meta['meta_value']); ?>
                        <?php endif; ?>
                        <br><br>
                        <span class="escrot-chat-date small">
                            <i class="fa fa-clock"></i> <?= esc_html($meta['creation_date']); ?>
                        </span>
                    </p>
                </li>
            <?php endif; ?>
        <?php endforeach; ?>
    </ul>
</div>
