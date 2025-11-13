# ======================================================
# NINJUMP.PY — Fixed & Clean Version by ChatGPT (for Ammar)
# ======================================================

import pygame
import random
import os
from pygame import mixer

# Initialize pygame
mixer.init()
pygame.init()

# Game window dimensions
SCREEN_WIDTH = 400
SCREEN_HEIGHT = 600

# Create game window
screen = pygame.display.set_mode((SCREEN_WIDTH, SCREEN_HEIGHT))
pygame.display.set_caption('Ninjump')

# Set frame rate
clock = pygame.time.Clock()
FPS = 50

# Game variables
SCROLL_THRESH = 200
GRAVITY = 1
MAX_PLATFORMS = 10
scroll = 0
bg_scroll = 0
game_over = False
score = 0
fade_counter = 0

# Load / create high score
try:
    with open('score.txt', 'r') as file:
        high_score = int(file.read())
except:
    high_score = 0

# Define colours
WHITE = (255, 255, 255)
BLACK = (0, 0, 0)
PANEL = (153, 217, 234)

# Define font
font_small = pygame.font.SysFont('Lucida Sans', 20)
font_big = pygame.font.SysFont('Lucida Sans', 24)

# Load images
jumpy_image = pygame.image.load('ninja121.png').convert_alpha()
bg_image = pygame.image.load('cloud.png').convert_alpha()
platform_image = pygame.image.load('dirt.png').convert_alpha()

# Load music and sounds
pygame.mixer.music.load('backsound.mp3')
pygame.mixer.music.set_volume(0.3)
pygame.mixer.music.play(-1, 0.0)

# Function for outputting text onto the screen
def draw_text(text, font, text_col, x, y):
    img = font.render(text, True, text_col)
    screen.blit(img, (x, y))

# Function for drawing info panel
def draw_panel():
    pygame.draw.rect(screen, PANEL, (0, 0, SCREEN_WIDTH, 30))
    pygame.draw.line(screen, WHITE, (0, 30), (SCREEN_WIDTH, 30), 2)
    draw_text('SCORE: ' + str(score), font_small, WHITE, 0, 0)
    draw_text('HIGH: ' + str(high_score), font_small, WHITE, 280, 0)

# Function for drawing the background
def draw_bg(bg_scroll):
    screen.blit(bg_image, (0, 0 + bg_scroll))
    screen.blit(bg_image, (0, -600 + bg_scroll))

# Player class
class Player():
    def __init__(self, x, y):
        self.image = pygame.transform.scale(jumpy_image, (45, 45))
        self.width = 25
        self.height = 40
        self.rect = pygame.Rect(0, 0, self.width, self.height)
        self.rect.center = (x, y)
        self.vel_y = 0
        self.flip = False

    def move(self):
        scroll = 0
        dx = 0
        dy = 0

        # Keyboard input
        key = pygame.key.get_pressed()
        if key[pygame.K_LEFT]:
            dx = -10
            self.flip = True
        if key[pygame.K_RIGHT]:
            dx = 10
            self.flip = False

        # Gravity
        self.vel_y += GRAVITY
        dy += self.vel_y

        # Screen wrap (teleport kiri-kanan)
        if self.rect.left + dx < 0:
            self.rect.right = SCREEN_WIDTH
        elif self.rect.right + dx > SCREEN_WIDTH:
            self.rect.left = 0

        # Collision with platforms
        for platform in platform_group:
            if platform.rect.colliderect(self.rect.x, self.rect.y + dy, self.width, self.height):
                if self.rect.bottom < platform.rect.centery and self.vel_y > 0:
                    self.rect.bottom = platform.rect.top
                    dy = 0
                    self.vel_y = -20  # lompat lagi otomatis

        # Scroll camera
        if self.rect.top <= SCROLL_THRESH and self.vel_y < 0:
            scroll = -dy

        # Update position
        self.rect.x += dx
        self.rect.y += dy + scroll

        return scroll

    def draw(self):
        screen.blit(pygame.transform.flip(self.image, self.flip, False), (self.rect.x - 12, self.rect.y - 5))

# Platform class
class Platform(pygame.sprite.Sprite):
    def __init__(self, x, y, width):
        pygame.sprite.Sprite.__init__(self)
        self.image = pygame.transform.scale(platform_image, (width, 10))
        self.rect = self.image.get_rect()
        self.rect.x = x
        self.rect.y = y

    def update(self, scroll):
        self.rect.y += scroll
        if self.rect.top > SCREEN_HEIGHT:
            self.kill()

# Player instance
jumpy = Player(SCREEN_WIDTH // 2, SCREEN_HEIGHT - 150)

# Create sprite groups
platform_group = pygame.sprite.Group()

# Create starting platform
start_platform = Platform(SCREEN_WIDTH // 2 - 50, SCREEN_HEIGHT - 50, 100)
platform_group.add(start_platform)

# =========================
# Main Game Loop
# =========================
run = True
while run:

    clock.tick(FPS)

    if not game_over:
        screen.fill((0, 0, 0))  # clear screen

        # Move player
        scroll = jumpy.move()

        # Background
        bg_scroll += scroll
        bg_scroll %= 600
        draw_bg(bg_scroll)

        # Generate new platforms
        while len(platform_group) < MAX_PLATFORMS:
            p_w = random.randint(40, 60)
            p_x = random.randint(0, SCREEN_WIDTH - p_w)
            p_y = min([p.rect.y for p in platform_group]) - random.randint(80, 120)
            new_platform = Platform(p_x, p_y, p_w)
            platform_group.add(new_platform)

        # Update platforms
        platform_group.update(scroll)

        # Update score
        if scroll > 0:
            score += scroll

        # Draw previous high score line
        pygame.draw.line(screen, WHITE, (0, score - high_score + SCROLL_THRESH),
                         (SCREEN_WIDTH, score - high_score + SCROLL_THRESH), 3)
        draw_text('HIGH SCORE', font_small, WHITE, SCREEN_WIDTH - 130,
                  score - high_score + SCROLL_THRESH)

        # Draw sprites
        platform_group.draw(screen)
        jumpy.draw()

        # Draw panel
        draw_panel()

        # Check game over
        if jumpy.rect.top > SCREEN_HEIGHT:
            game_over = True

    else:
        # Game Over Fade
        if fade_counter < SCREEN_WIDTH:
            fade_counter += 5
            for y in range(0, 6, 2):
                pygame.draw.rect(screen, BLACK, (0, y * 100, fade_counter, 100))
                pygame.draw.rect(screen, BLACK, (SCREEN_WIDTH - fade_counter, (y + 1) * 100, SCREEN_WIDTH, 100))
        else:
            draw_text('GAME OVER!', font_big, WHITE, 130, 200)
            draw_text('SCORE: ' + str(int(score)), font_big, WHITE, 130, 250)
            draw_text('PRESS SPACE TO PLAY AGAIN', font_small, WHITE, 60, 300)

            # Update high score
            if score > high_score:
                high_score = int(score)
                with open('score.txt', 'w') as file:
                    file.write(str(high_score))

            key = pygame.key.get_pressed()
            if key[pygame.K_SPACE]:
                # Reset game
                game_over = False
                score = 0
                scroll = 0
                bg_scroll = 0
                fade_counter = 0
                jumpy.rect.center = (SCREEN_WIDTH // 2, SCREEN_HEIGHT - 150)
                platform_group.empty()
                start_platform = Platform(SCREEN_WIDTH // 2 - 50, SCREEN_HEIGHT - 50, 100)
                platform_group.add(start_platform)

    # Event handler
    for event in pygame.event.get():
        if event.type == pygame.QUIT:
            if score > high_score:
                with open('score.txt', 'w') as file:
                    file.write(str(int(high_score)))
            run = False

    # Update display
    pygame.display.update()

pygame.quit()
