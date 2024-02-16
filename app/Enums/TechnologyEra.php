<?php

namespace App\Enums;

use App\GameConcept;
use App\Technologies\TechnologyType;
use Illuminate\Support\Collection;

enum TechnologyEra: string implements GameConcept
{
    use GameConceptEnum;

    public const BASE_COST = 15;
    public const BASE_STRENGTH = 4;
    public const BASE_ARMOR_COST = 5;
    public const BASE_ARMOR_STRENGTH = 1;

    case Neolithic = 'Neolithic';
    case Copper = 'Copper';
    case Bronze = 'Bronze';
    case Iron = 'Iron';
    case Classical = 'Classical';
    case Medieval = 'Medieval';
    case HighMedieval = 'HighMedieval';
    case Renaissance = 'Renaissance';
    case Enlightenment = 'Enlightenment';
    case Industrial = 'Industrial';
    case Gilded = 'Gilded';
    case Modern = 'Modern';
    case Atomic = 'Atomic';
    case Digital = 'Digital';
    case Information = 'Information';
    case Nano = 'Nano';

    public function baseArmorStrength(): int
    {
        return match ($this) {
            self::Neolithic => self::BASE_ARMOR_STRENGTH,
            self::Copper => 2,
            self::Bronze => 3,
            self::Iron => 4,
            self::Classical => 5,
            self::Medieval => 6,
            self::HighMedieval => 7,
            self::Renaissance => 8,
            self::Enlightenment => 9,
            self::Industrial => 10,
            self::Gilded => 11,
            self::Modern => 12,
            self::Atomic => 13,
            self::Digital => 15,
            self::Information => 18,
            self::Nano => 20,
        };
    }

    public function baseCost(): int
    {
        return match ($this) {
            self::Neolithic => self::BASE_COST,
            self::Copper => 20,
            self::Bronze => 25,
            self::Iron => 30,
            self::Classical => 40,
            self::Medieval => 50,
            self::HighMedieval => 60,
            self::Renaissance => 80,
            self::Enlightenment => 110,
            self::Industrial => 150,
            self::Gilded => 220,
            self::Modern => 330,
            self::Atomic => 500,
            self::Digital => 800,
            self::Information => 1400,
            self::Nano => 2300,
        };
    }

    public function baseStrength(): int
    {
        return match ($this) {
            self::Neolithic => self::BASE_STRENGTH,
            self::Copper => 5,
            self::Bronze => 7,
            self::Iron => 9,
            self::Classical => 12,
            self::Medieval => 14,
            self::HighMedieval => 16,
            self::Renaissance => 21,
            self::Enlightenment => 24,
            self::Industrial => 28,
            self::Gilded => 36,
            self::Modern => 41,
            self::Atomic => 47,
            self::Digital => 61,
            self::Information => 70,
            self::Nano => 80,
        };
    }

    public function description(): string
    {
        return match ($this) {
            self::Neolithic => 'The Neolithic era, also known as the New Stone Age, was the final and most advanced stage of cultural evolution among prehistoric humans. It began about 12,000 years ago in the Near East, where the first farming communities emerged from the Natufian culture. It spread gradually to other parts of the world, reaching Europe, Asia, and Africa at different times. The Neolithic era lasted until the development of metal tools and the rise of complex civilizations in the Bronze Age and the Iron Age.

The Neolithic era was characterized by a number of innovations that transformed human society and the environment. The most important of these was the domestication of plants and animals, which allowed people to produce their own food and settle in permanent villages. This led to the growth of population, social stratification, trade, and warfare. The Neolithic era also witnessed the invention of pottery, weaving, megalithic architecture, and various forms of art and religion. The Neolithic people developed polished stone tools, such as axes, knives, and sickles, that were more efficient and durable than the chipped stone tools of the previous periods.

The Neolithic era had a profound impact on the history and culture of humanity. It marked the transition from a nomadic, hunter-gatherer lifestyle to a sedentary, agricultural one. It created the conditions for the emergence of the first civilizations and the development of writing, law, and science. It also altered the natural environment, as the Neolithic people cleared forests, drained wetlands, and cultivated crops. The Neolithic era was a time of great change and diversity, as different regions and cultures adapted to the new challenges and opportunities of the Neolithic revolution.',

            self::Copper => 'The copper era, also known as the Chalcolithic or the Eneolithic, was a glorious period of human history that spanned from about 4500 BC to 3500 BC. It marked the dawn of metallurgy, as humans learned to smelt and shape copper, the first metal they ever used. Copper was a precious and versatile material that enabled the creation of new tools, weapons, ornaments, and art. It also stimulated trade, communication, and innovation across different regions and cultures.

The copper era witnessed remarkable achievements and developments in various fields of human endeavor. Agriculture, pottery, weaving, and architecture flourished, as well as social organization, religion, and warfare. Some of the most notable civilizations of this era include the Vinča culture in the Balkans, the Beaker culture in Western Europe, the Cucuteni-Trypillian culture in Eastern Europe, and the Indus Valley civilization in South Asia. These cultures produced magnificent artifacts and monuments, such as copper axes, beakers, figurines, seals, and megaliths.

The copper era also paved the way for the subsequent Bronze Age, in which copper was alloyed with tin or arsenic to produce a stronger and harder metal. The discovery of bronze revolutionized human history, as it enabled the rise of more complex and powerful societies, such as the Sumerians, the Egyptians, the Minoans, and the Mycenaeans. The copper era, therefore, was a crucial and transformative stage in the evolution of humanity, as it demonstrated the ingenuity, creativity, and adaptability of our ancestors.',

            self::Bronze => 'The bronze era was a glorious period in human history, spanning from around 3300 BCE to 1200 BCE, when civilizations across the world discovered and mastered the art of metalworking. By alloying copper and tin, they created a new material that was stronger, more durable, and more versatile than any other known before. With bronze, they forged weapons, tools, armor, ornaments, and statues that reflected their power, wealth, and creativity.

The bronze era witnessed the rise and fall of many empires and cultures, such as the Sumerians, Babylonians, Egyptians, Minoans, Mycenaeans, Hittites, Shang, and Indus Valley. They developed writing, mathematics, astronomy, law, trade, and religion, and left behind monumental works of architecture, literature, and art. They also engaged in wars, alliances, and diplomacy, shaping the political and geographical landscape of their regions.

The bronze era came to an end with the collapse of many civilizations around 1200 BCE, due to a combination of factors such as climate change, invasions, migrations, and social unrest. The loss of trade networks and resources led to a decline in bronze production and a transition to the iron age. However, the legacy of the bronze era lives on in the history, culture, and heritage of humanity.',

            self::Iron => 'The Iron Age was a glorious epoch in human history, when the use of iron and steel transformed the world with new technologies, cultures, and civilizations. It began around 1200 BCE in the Mediterranean and Near East, following the collapse of the Bronze Age empires, and lasted until the rise of the classical civilizations of Greece and Rome. In other regions, such as China, India, and Scandinavia, the Iron Age started and ended at different times, depending on the local conditions and innovations.

The Iron Age witnessed remarkable advances in human kind, such as the development of iron metallurgy, which enabled the production of stronger and sharper tools and weapons, the expansion of trade and commerce, the emergence of alphabetic writing and literature, the rise of monotheistic religions and ethical philosophies, and the creation of complex political and social structures, such as city-states, kingdoms, and empires. Iron also played a key role in agriculture, art, architecture, and engineering, as well as in warfare and conquest.

The Iron Age also had profound cultural and military impacts on the world, as it fostered the spread and interaction of diverse peoples, languages, and beliefs. Some of the most influential civilizations of the Iron Age include the Persians, who built a vast empire that stretched from Egypt to India, the Greeks, who pioneered democracy, philosophy, and science, the Romans, who established a republic and a law code, the Celts, who excelled in art and metalwork, the Chinese, who invented paper and gunpowder, and the Vikings, who explored and settled in new lands. The Iron Age was a period of dynamic change and innovation that shaped the course of human history.',

            self::Classical => 'The Classical era was a glorious period of human history that spanned from the 8th century BCE to the 6th century CE, encompassing the civilizations of ancient Greece and Rome. It was a time of remarkable achievements in art, literature, philosophy, science, politics, and law, as well as epic wars and conquests that shaped the world for centuries to come.

The Classical era witnessed the birth of democracy, the rise of philosophy, the development of drama and poetry, the invention of mathematics and astronomy, the creation of magnificent sculptures and architecture, and the exploration of new lands and cultures. The Classical era also produced some of the most influential figures in history, such as Socrates, Plato, Aristotle, Homer, Sophocles, Alexander the Great, Julius Caesar, Augustus, Cicero, and Virgil.

The Classical era also had a profound cultural and military impact on the world. The Greeks and Romans spread their language, religion, art, and law throughout the Mediterranean and beyond, creating a legacy that still resonates today. The Classical era also saw the rise and fall of great empires, such as the Persian Empire, the Macedonian Empire, the Roman Republic, and the Roman Empire, as well as the emergence of new powers, such as the Parthians, the Sassanids, and the Byzantines. The Classical era was a time of glory, wisdom, and innovation, but also of conflict, violence, and decline.',

            self::Medieval => 'The Medieval era, also known as the Middle Ages, was a long and tumultuous period in European history that spanned from the 5th to the 15th century. It was marked by the collapse of the Roman Empire, the rise of feudalism, the emergence of Christianity and Islam, and the constant threat of invasions and wars.

Despite the challenges and hardships, the Medieval era also witnessed remarkable achievements and innovations in various fields of human endeavor. Some of the notable advances include the development of the Gothic architecture, the invention of the printing press, the establishment of the first universities, the creation of the Magna Carta, and the discovery of the New World.

The Medieval era had a profound and lasting impact on the culture and society of Europe and beyond. It shaped the languages, literature, art, music, philosophy, and law of the modern world. It also influenced the formation of nations, kingdoms, and empires, as well as the emergence of the Renaissance and the Reformation. The Medieval era was a time of both darkness and light, of both chaos and order, of both despair and hope.',

            self::HighMedieval => 'The High Medieval era was a glorious period of human history that spanned from the 11th to the 13th centuries. It was marked by the expansion of trade, commerce, and urbanization, as well as the rise of powerful kingdoms, empires, and papal authority. It was also a time of cultural and intellectual flourishing, with the emergence of the Romanesque and Gothic art and architecture, the development of scholasticism and universities, and the revival of classical learning and literature.

The High Medieval era witnessed many advances to human kind in various fields of science, technology, and medicine. Some of the notable inventions and discoveries include the magnetic compass, the mechanical clock, the windmill, the watermill, the eyeglasses, the printing press, the astrolabe, the Arabic numerals, and the decimal system. The High Medieval era also saw the improvement of agriculture, navigation, and warfare, as well as the introduction of new crops, spices, and textiles from Asia and Africa.

The High Medieval era had a significant cultural and military impact on the world, as it was a time of religious fervor, crusades, and conflicts. The era saw the spread of Christianity and Islam, as well as the emergence of new religious movements such as the Cathars, the Waldensians, and the Franciscans. The era also witnessed the clash of civilizations, such as the Norman conquest of England, the Reconquista of Spain, the Mongol invasions of Europe and Asia, and the Hundred Years’ War between France and England. The High Medieval era was a remarkable epoch that shaped the course of human history and civilization.',

            self::Renaissance => 'The Renaissance was a glorious period of history that spanned from the 14th to the 17th century, marking the transition from the Middle Ages to the modern world. It was a time of rebirth, discovery, and innovation, as humanists, artists, scientists, and explorers challenged the authority of the church and the feudal system, and sought to revive the classical ideals of ancient Greece and Rome.

The Renaissance witnessed remarkable advances in human knowledge and creativity, such as the invention of the printing press, the development of perspective in painting, the exploration of new lands and cultures, the emergence of vernacular literature, and the formulation of new theories in astronomy, physics, and anatomy. Some of the most influential figures of this era include Leonardo da Vinci, Michelangelo, Raphael, Galileo, Copernicus, Shakespeare, Dante, and Machiavelli.

The Renaissance also had significant cultural and military impacts on Europe and the world. It fostered a new sense of individualism, secularism, and humanism, as well as a spirit of curiosity and experimentation. It also sparked religious conflicts, such as the Protestant Reformation and the Catholic Counter-Reformation, and political upheavals, such as the rise of nation-states, the decline of feudalism, and the wars of the Italian city-states. The Renaissance was a catalyst for change and progress that shaped the course of history and civilization.',

            self::Enlightenment => 'The Enlightenment era was a remarkable period of intellectual and cultural transformation that spanned from the late 17th to the early 19th century. It was marked by a profound shift in the way people viewed the world, themselves, and their place in society. The Enlightenment challenged the authority of tradition, religion, and monarchy, and promoted the ideals of reason, liberty, and progress.

The Enlightenment era witnessed major advances in various fields of human endeavor, such as philosophy, science, art, literature, and politics. Some of the most influential thinkers of this era were John Locke, Isaac Newton, Voltaire, Jean-Jacques Rousseau, Immanuel Kant, and Adam Smith. They contributed to the development of concepts such as natural rights, social contract, empiricism, rationalism, deism, and free market. The Enlightenment also fostered a spirit of curiosity and exploration, leading to the discovery of new lands, peoples, and cultures.

The Enlightenment era had a significant impact on the cultural and military affairs of Europe and beyond. It inspired movements such as the American Revolution, the French Revolution, and the Latin American wars of independence, which sought to overthrow the oppressive regimes of the old order and establish democratic republics based on the principles of the Enlightenment. The Enlightenment also influenced the development of art forms such as neoclassicism, rococo, and romanticism, which reflected the changing tastes and values of the time. The Enlightenment era was a pivotal moment in the history of humanity, as it paved the way for the modern world.',

            self::Industrial => 'The Industrial era was a remarkable period of economic and social transformation that spanned from the late 18th to the early 20th century. It was marked by a rapid growth of industry, urbanization, and population, driven by the development and application of new technologies, such as steam engines, railways, factories, and electricity.

The Industrial era witnessed major advances in various fields of human endeavor, such as engineering, medicine, communication, and transportation. Some of the most influential inventors and innovators of this era were James Watt, Eli Whitney, Samuel Morse, Alexander Graham Bell, Thomas Edison, and Henry Ford. They contributed to the improvement of productivity, efficiency, and living standards for millions of people. The Industrial era also fostered a spirit of entrepreneurship and competition, leading to the emergence of new markets, businesses, and corporations.

The Industrial era had a significant impact on the cultural and military affairs of the world. It inspired movements such as the labor movement, the women’s movement, and the social reform movement, which sought to improve the working and living conditions of the masses, and to secure their rights and freedoms. The Industrial era also influenced the development of art forms such as realism, impressionism, and modernism, which reflected the changing realities and perspectives of the time. The Industrial era was a pivotal moment in the history of humanity, as it ushered in the modern era.',

            self::Gilded => 'The Gilded era was a remarkable period of economic and social transformation that spanned from the late 19th to the early 20th century. It was marked by a massive expansion of industry, commerce, and immigration, driven by the development and application of new technologies, such as telephones, automobiles, and skyscrapers.

The Gilded era witnessed major advances in various fields of human endeavor, such as education, entertainment, journalism, and philanthropy. Some of the most influential figures of this era were Andrew Carnegie, John D. Rockefeller, J. P. Morgan, Mark Twain, and Theodore Roosevelt. They contributed to the creation of vast fortunes, cultural icons, and social reforms. The Gilded era also fostered a spirit of innovation and ambition, leading to the emergence of new inventions, industries, and movements.

The Gilded era had a significant impact on the cultural and military affairs of the nation and the world. It inspired movements such as the Populist movement, the Progressive movement, and the Civil Rights movement, which sought to challenge the corruption, inequality, and injustice of the system, and to secure the rights and opportunities of the people. The Gilded era also influenced the development of art forms such as realism, naturalism, and regionalism, which reflected the diversity and complexity of the time. The Gilded era was a pivotal moment in the history of humanity, as it shaped the modern America.',

            self::Modern => 'The Modern Era was a remarkable period of turmoil and transformation that spanned from the dawn of the 20th century to the end of the Second World War. It was marked by a series of conflicts, crises, and revolutions, that reshaped the political and social order of the world, and challenged the values and beliefs of humanity.

The Modern Era witnessed major advances in various fields of human endeavor, such as science, technology, art, and literature. Some of the most influential figures of this era were Albert Einstein, Marie Curie, Sigmund Freud, Pablo Picasso, and George Orwell. They contributed to the development of concepts such as relativity, radioactivity, psychoanalysis, cubism, and dystopia. The Modern Era also fostered a spirit of creativity and experimentation, leading to the emergence of new inventions, genres, and movements.

The Modern Era had a significant impact on the cultural and military affairs of the world. It inspired movements such as the suffrage movement, the civil rights movement, and the anti-colonial movement, which sought to secure the rights and dignity of the oppressed and marginalized groups. The Modern Era also influenced the development of art forms such as expressionism, surrealism, and jazz, which reflected the emotions and aspirations of the time. The Modern Era was a pivotal moment in the history of humanity.',

            self::Atomic => 'The Atomic era was a remarkable period of scientific and technological breakthroughs that spanned from the mid-20th century to the present day. It was marked by the discovery and harnessing of nuclear energy, which opened up new possibilities and challenges for humanity.

The Atomic era witnessed major advances in various fields of human endeavor, such as physics, chemistry, biology, medicine, and space exploration. Some of the most influential figures of this era were Albert Einstein, Enrico Fermi, Robert Oppenheimer, Jonas Salk, and Neil Armstrong. They contributed to the development of concepts such as quantum mechanics, nuclear fission, nuclear fusion, polio vaccine, and moon landing. The Atomic era also fostered a spirit of curiosity and discovery, leading to the emergence of new phenomena, elements, and planets.

The Atomic era had a significant impact on the cultural and military affairs of the world. It inspired movements such as the environmental movement, the peace movement, and the human rights movement, which sought to protect the planet, prevent nuclear war, and promote the dignity of all people. The Atomic era also influenced the development of art forms such as pop art, rock music, and science fiction, which reflected the hopes and fears of the time. The Atomic era was a pivotal moment in the history of humanity, as it transformed the modern world.',

            self::Digital => 'The Digital era was a remarkable period of information and communication revolution that spanned from the late 20th century to the present day. It was marked by the development and diffusion of digital technologies, such as computers, internet, smartphones, and social media, which enabled unprecedented levels of connectivity, creativity, and collaboration.

The Digital era witnessed major advances in various fields of human endeavor, such as education, health, entertainment, and commerce. Some of the most influential figures of this era were Bill Gates, Steve Jobs, Tim Berners-Lee, Mark Zuckerberg, and Elon Musk. They contributed to the creation of products, platforms, and services that transformed the way people learn, work, play, and interact. The Digital era also fostered a spirit of innovation and entrepreneurship, leading to the emergence of new industries, markets, and opportunities.

The Digital era had a significant impact on the cultural and military affairs of the world. It inspired movements such as the globalization movement, the democracy movement, and the cyber security movement, which sought to enhance the integration, participation, and protection of the global community. The Digital era also influenced the development of art forms such as digital art, electronic music, and video games, which reflected the diversity and dynamism of the time. The Digital era was a pivotal moment in the history of humanity, as it shaped the modern world.',

            self::Information => 'The Information era was a remarkable period of knowledge and intelligence explosion that spanned from the late 20th century to the present day. It was marked by the development and application of artificial intelligence, big data, cloud computing, and biotechnology, which enabled unprecedented levels of insight, innovation, and impact.

The Information era witnessed major advances in various fields of human endeavor, such as science, medicine, engineering, and education. Some of the most influential figures of this era were Stephen Hawking, Craig Venter, Jeff Bezos, and Satya Nadella. They contributed to the creation of breakthroughs, discoveries, and solutions that enhanced the understanding, health, and well-being of humanity. The Information era also fostered a spirit of collaboration and diversity, leading to the emergence of new networks, communities, and cultures.

The Information era had a significant impact on the cultural and military affairs of the world. It inspired movements such as the open source movement, the social justice movement, and the cyber warfare movement, which sought to leverage the power, potential, and risks of the information age. The Information era also influenced the development of art forms such as digital media, interactive art, and virtual reality, which reflected the imagination and expression of the time. The Information era was a pivotal moment in the history of humanity, as it shaped the future of the world.',

            self::Nano => 'The Nano era was a remarkable period of molecular and atomic manipulation that spanned from the early 21st century to the present day. It was marked by the development and application of nanotechnology, which enabled unprecedented levels of control, precision, and functionality at the nanoscale.

The Nano era witnessed major advances in various fields of human endeavor, such as medicine, energy, materials, and computing. Some of the most influential figures of this era were Eric Drexler, Richard Feynman, K. Eric Lander, and Ray Kurzweil. They contributed to the creation of concepts, devices, and systems that revolutionized the diagnosis, treatment, and prevention of diseases, the generation, storage, and distribution of clean and renewable energy, the design, synthesis, and performance of novel and smart materials, and the speed, capacity, and intelligence of computers.

The Nano era had a significant impact on the cultural and military affairs of the world. It inspired movements such as the transhumanist movement, the nanosafety movement, and the nanoweaponry movement, which sought to explore the possibilities, limitations, and implications of the nanotechnology age. The Nano era also influenced the development of art forms such as nanosculpture, nanomusic, and nanogames, which reflected the aesthetics and challenges of the time. The Nano era was a pivotal moment in the history of humanity, as it shaped the future of the world.',
        };
    }

    public function order(): int
    {
        return match ($this) {
            self::Neolithic => 1,
            self::Copper => 2,
            self::Bronze => 3,
            self::Iron => 4,
            self::Classical => 5,
            self::Medieval => 6,
            self::HighMedieval => 7,
            self::Renaissance => 8,
            self::Enlightenment => 9,
            self::Industrial => 10,
            self::Gilded => 11,
            self::Modern => 12,
            self::Atomic => 13,
            self::Digital => 14,
            self::Information => 15,
            self::Nano => 16,
        };
    }

    public function name(): string
    {
        return \Str::title(str_replace('-', ' ', "{$this->slug()} era"));
    }

    public function slug(): string
    {
        return \Str::kebab($this->name);
    }

    /**
     * @return Collection<int, TechnologyType>
     */
    public function technologies(): Collection
    {
        return TechnologyType::all()->filter(fn(TechnologyType $type) => $type->era() === $this);
    }

    public function icon(): string
    {
        return YieldType::Science->icon();
    }

    /** @return Collection<int, GameConcept> */
    public function items(): Collection
    {
        return TechnologyType::all()->filter(
            fn(TechnologyType $type) => $type->era() === $this
        );
    }

    public function typeSlug(): string
    {
        return 'technology';
    }
}
