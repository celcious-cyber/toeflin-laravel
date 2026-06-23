<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Question;
use App\Models\TestPackage;

class DummyFullTestSeeder extends Seeder
{
    public function run(): void
    {
        $allQuestions = [];

        // ================================================================
        // SECTION 1: LISTENING COMPREHENSION (50 soal)
        // ================================================================
        $listeningQuestions = [
            // Part A: Short Conversations (1-30)
            ['What does the woman mean?', ['a'=>'She already finished the report.','b'=>'She needs more time to complete it.','c'=>'She does not want to write the report.','d'=>'She forgot about the deadline.'], 'b'],
            ['What does the man imply?', ['a'=>'He enjoyed the lecture.','b'=>'He fell asleep during class.','c'=>'The lecture was too short.','d'=>'The professor was absent.'], 'a'],
            ['What will the woman probably do next?', ['a'=>'Go to the library.','b'=>'Have lunch first.','c'=>'Call her friend.','d'=>'Return to the dormitory.'], 'a'],
            ['What does the man suggest?', ['a'=>'Taking the bus instead.','b'=>'Walking to the campus.','c'=>'Borrowing a car.','d'=>'Waiting for the rain to stop.'], 'd'],
            ['What can be inferred about the woman?', ['a'=>'She is a new student.','b'=>'She has been to the museum before.','c'=>'She does not like art.','d'=>'She works at the museum.'], 'a'],
            ['What does the man mean?', ['a'=>'The book is too expensive.','b'=>'He will lend the woman his copy.','c'=>'The bookstore is closed.','d'=>'He has not read the book yet.'], 'b'],
            ['What is the woman\'s problem?', ['a'=>'She cannot find her keys.','b'=>'She lost her student ID.','c'=>'She missed the registration deadline.','d'=>'She forgot her password.'], 'c'],
            ['What does the man imply about the course?', ['a'=>'It is easier than expected.','b'=>'It requires a lot of reading.','c'=>'The professor is very strict.','d'=>'There are no exams.'], 'b'],
            ['What will the man probably do?', ['a'=>'Change his major.','b'=>'Drop the chemistry class.','c'=>'Study harder for the exam.','d'=>'Talk to his advisor.'], 'c'],
            ['What does the woman suggest?', ['a'=>'They should study together.','b'=>'He should see a doctor.','c'=>'They should take a break.','d'=>'He should call the professor.'], 'a'],
            ['What can be inferred from the conversation?', ['a'=>'The man is late for class.','b'=>'The woman missed the bus.','c'=>'Both are going to the same place.','d'=>'The class has been canceled.'], 'd'],
            ['What does the man mean?', ['a'=>'He agrees with the woman.','b'=>'He disagrees with her opinion.','c'=>'He has no opinion on the matter.','d'=>'He needs more information.'], 'b'],
            ['What is the woman\'s reaction?', ['a'=>'She is surprised.','b'=>'She is disappointed.','c'=>'She is excited.','d'=>'She is confused.'], 'a'],
            ['What does the man plan to do this weekend?', ['a'=>'Visit his parents.','b'=>'Work on his thesis.','c'=>'Go to a concert.','d'=>'Clean his apartment.'], 'b'],
            ['What problem does the woman have?', ['a'=>'Her computer crashed.','b'=>'She cannot access the website.','c'=>'Her printer is broken.','d'=>'She forgot to save her file.'], 'd'],
            ['What does the man imply?', ['a'=>'The restaurant is too far away.','b'=>'The food there is not very good.','c'=>'They should try a different place.','d'=>'He is not hungry.'], 'c'],
            ['What does the woman mean?', ['a'=>'She has already submitted the application.','b'=>'She is still working on it.','c'=>'She decided not to apply.','d'=>'The deadline has passed.'], 'a'],
            ['What can be concluded about the man?', ['a'=>'He is a teaching assistant.','b'=>'He is taking the course for the first time.','c'=>'He has taken the course before.','d'=>'He does not like the subject.'], 'c'],
            ['What does the woman suggest the man do?', ['a'=>'Read the textbook carefully.','b'=>'Attend the review session.','c'=>'Form a study group.','d'=>'All of the above.'], 'b'],
            ['What does the man mean when he says he is "swamped"?', ['a'=>'He is very busy.','b'=>'He is feeling sick.','c'=>'He is bored.','d'=>'He is confused.'], 'a'],
            ['What does the woman imply about the assignment?', ['a'=>'It was too easy.','b'=>'It took longer than expected.','c'=>'It was not graded fairly.','d'=>'It was optional.'], 'b'],
            ['Where does this conversation most likely take place?', ['a'=>'In a classroom.','b'=>'At a cafeteria.','c'=>'In a library.','d'=>'At a bus stop.'], 'c'],
            ['What does the man want to do?', ['a'=>'Borrow a book from the library.','b'=>'Return a borrowed item.','c'=>'Reserve a study room.','d'=>'Print some documents.'], 'c'],
            ['What does the woman say about Professor Kim?', ['a'=>'He is very demanding.','b'=>'He canceled class today.','c'=>'He is an excellent lecturer.','d'=>'He is retiring this year.'], 'c'],
            ['What is the main topic of the conversation?', ['a'=>'A research project.','b'=>'A summer internship.','c'=>'A scholarship application.','d'=>'A housing arrangement.'], 'b'],
            ['What does the man recommend?', ['a'=>'Taking notes by hand.','b'=>'Using a laptop in class.','c'=>'Recording the lectures.','d'=>'Reading the syllabus.'], 'a'],
            ['What does the woman plan to do after graduation?', ['a'=>'Attend graduate school.','b'=>'Travel abroad.','c'=>'Start working immediately.','d'=>'Take a gap year.'], 'a'],
            ['What problem does the man describe?', ['a'=>'His roommate is too noisy.','b'=>'His dorm room is too small.','c'=>'The heating system is broken.','d'=>'The internet is not working.'], 'a'],
            ['What does the woman imply?', ['a'=>'She thinks the exam will be difficult.','b'=>'She is confident about the test.','c'=>'She has not started studying.','d'=>'She prefers oral exams.'], 'b'],
            ['What does the man suggest they do?', ['a'=>'Go to the professor\'s office hours.','b'=>'Wait until next semester.','c'=>'Ask another classmate for help.','d'=>'Submit the project late.'], 'a'],
            // Part B: Longer Conversations (31-38)
            ['What is the conversation mainly about?', ['a'=>'Registering for next semester\'s classes.','b'=>'Finding a part-time job on campus.','c'=>'Applying for financial aid.','d'=>'Choosing a research topic.'], 'a'],
            ['According to the conversation, why is the woman concerned?', ['a'=>'The class she needs is already full.','b'=>'She cannot afford the tuition.','c'=>'She may not graduate on time.','d'=>'Her grades are too low.'], 'a'],
            ['What does the advisor suggest?', ['a'=>'Adding herself to the waitlist.','b'=>'Taking an alternative course.','c'=>'Speaking directly to the instructor.','d'=>'All of the above.'], 'd'],
            ['What can be inferred about the man?', ['a'=>'He is a freshman.','b'=>'He is a senior.','c'=>'He is an academic advisor.','d'=>'He is a graduate student.'], 'c'],
            ['What are the speakers mainly discussing?', ['a'=>'The benefits of study abroad programs.','b'=>'The requirements for a biology major.','c'=>'The university\'s new policies.','d'=>'The upcoming campus event.'], 'a'],
            ['What does the woman say about her experience in Spain?', ['a'=>'It was challenging but rewarding.','b'=>'She did not enjoy it.','c'=>'She could not understand the language.','d'=>'She wants to go back next year.'], 'a'],
            ['Why does the man mention his budget?', ['a'=>'To explain why he cannot participate.','b'=>'To show that the program is affordable.','c'=>'To ask for a scholarship.','d'=>'To compare costs of different programs.'], 'a'],
            ['What does the woman recommend?', ['a'=>'Applying for a travel grant.','b'=>'Choosing a shorter program.','c'=>'Working part-time while abroad.','d'=>'Going to a less expensive country.'], 'a'],
            // Part C: Talks/Lectures (39-50)
            ['What is the lecture mainly about?', ['a'=>'The history of the printing press.','b'=>'The development of modern photography.','c'=>'The evolution of communication technology.','d'=>'The invention of the telegraph.'], 'c'],
            ['According to the professor, what was the most significant impact of the printing press?', ['a'=>'It made books cheaper.','b'=>'It spread literacy to the masses.','c'=>'It eliminated the need for scribes.','d'=>'It improved the quality of paper.'], 'b'],
            ['What does the professor say about the telegraph?', ['a'=>'It was invented in France.','b'=>'It was the first electronic communication device.','c'=>'It replaced the postal service.','d'=>'It was too expensive for common use.'], 'b'],
            ['What will the professor probably discuss next?', ['a'=>'The invention of the telephone.','b'=>'The history of radio broadcasting.','c'=>'Modern social media.','d'=>'The postal system in the 18th century.'], 'a'],
            ['What is the main topic of this talk?', ['a'=>'Marine biology and ocean ecosystems.','b'=>'The effects of pollution on rivers.','c'=>'Climate change and its global impact.','d'=>'Renewable energy sources.'], 'a'],
            ['According to the speaker, what threatens coral reefs the most?', ['a'=>'Overfishing.','b'=>'Rising ocean temperatures.','c'=>'Plastic pollution.','d'=>'Coastal development.'], 'b'],
            ['What does the speaker suggest as a solution?', ['a'=>'Banning all fishing activities.','b'=>'Establishing more marine protected areas.','c'=>'Reducing carbon emissions globally.','d'=>'Both B and C.'], 'd'],
            ['What can be inferred from the lecture?', ['a'=>'Marine ecosystems are resilient.','b'=>'The situation is urgent but not hopeless.','c'=>'Technology alone can solve the problem.','d'=>'Only governments can make a difference.'], 'b'],
            ['What is the focus of this lecture?', ['a'=>'Ancient Egyptian architecture.','b'=>'The Roman Empire\'s expansion.','c'=>'Greek philosophy and its influence.','d'=>'Medieval European trade routes.'], 'c'],
            ['According to the professor, why is Socrates important?', ['a'=>'He wrote many books.','b'=>'He developed the Socratic method of questioning.','c'=>'He founded the first university.','d'=>'He was a military leader.'], 'b'],
            ['What distinction does the professor make between Plato and Aristotle?', ['a'=>'Plato focused on ideal forms while Aristotle emphasized observation.','b'=>'Plato was older and wiser.','c'=>'Aristotle rejected all of Plato\'s ideas.','d'=>'They lived in different centuries.'], 'a'],
            ['What does the professor imply about modern education?', ['a'=>'It has no connection to Greek philosophy.','b'=>'It still uses many principles from Greek thinkers.','c'=>'It should return to ancient methods entirely.','d'=>'It is superior to ancient education.'], 'b'],
        ];

        foreach ($listeningQuestions as $i => $q) {
            $num = $i + 1;
            $choicesFormatted = [];
            $keys = ['a','b','c','d'];
            $j = 0;
            foreach ($q[1] as $k => $v) {
                $choicesFormatted[$keys[$j]] = $keys[$j] . ". " . $v;
                $j++;
            }
            
            $question = Question::create([
                'id' => Str::uuid()->toString(),
                'section' => 'Listening',
                'skillCategory' => null,
                'content' => "{$num}. {$q[0]}",
                'choices' => json_encode($choicesFormatted),
                'answerKey' => $q[2],
                'explanation' => '',
                'audioId' => null,
                'passageId' => null,
                'packageId' => null,
            ]);
            
            $shuffledEntries = [];
            foreach ($choicesFormatted as $k => $v) {
                $shuffledEntries[] = [$k, $v];
            }
            $allQuestions[] = [
                'id' => $question->id,
                'section' => 'Listening',
                'content' => $question->content,
                'choices' => $choicesFormatted,
                'answerKey' => $q[2],
                'shuffledEntries' => $shuffledEntries,
            ];
        }
        $this->command->info('✅ 50 soal Listening berhasil dibuat.');

        // ================================================================
        // SECTION 2: STRUCTURE & WRITTEN EXPRESSION (40 soal)
        // ================================================================
        $structureQuestions = [
            // Part A: Sentence Completion (1-15)
            ['1. The gray scale, a progressive series of shades ranging from black to white, is used in computer graphics _____ detail to graphical images.', ['a'=>'(A) added','b'=>'(B) to add','c'=>'(C) are added','d'=>'(D) and add'], 'b'],
            ['2. _____ skeleton of an insect is on the outside of its body.', ['a'=>'(A) Its','b'=>'(B) That the','c'=>'(C) There is a','d'=>'(D) The'], 'd'],
            ['3. Researchers have discovered that the weights of babies born in the winter are _____ the weights of those born at other times of the year.', ['a'=>'(A) as great','b'=>'(B) greater than','c'=>'(C) great as','d'=>'(D) the greatest'], 'b'],
            ['4. _____ the formation of ice crystals from water is not__(A) fully understood.', ['a'=>'(A) Why','b'=>'(B) The__(B) reason','c'=>'(C)__(C) Although','d'=>'(D) Despite'], 'a'],
            ['5. By _____ excluding competition from an industry, governments have often created public service monopolies.', ['a'=>'(A)__(A) they__(A) adopt__(A) laws','b'=>'(B) laws are adopted','c'=>'(C) adopting laws','d'=>'(D) having laws adopt'], 'c'],
            ['6. Cholesterol is present in large quantities in the nervous system, where _____ compound of myelin.', ['a'=>'(A) it a','b'=>'(B) a','c'=>'(C) being','d'=>'(D) it is a'], 'd'],
            ['7. Susan B. Anthony was _____ first women in the United States who _____ to vote.', ['a'=>'(A) one__(A) of__(A) the / tried','b'=>'(B) the__(B) one / tried','c'=>'(C) one / trying','d'=>'(D) was__(D) one / try'], 'a'],
            ['8. _____ of classical ballet in the United States began around 1830.', ['a'=>'(A) To teach','b'=>'(B) Is teaching','c'=>'(C) It was taught','d'=>'(D) The teaching'], 'd'],
            ['9. Not until the seventeenth century _____ to measure the








 


speed of light.', ['a'=>'(A) anyone__(A) attempted','b'=>'(B) did anyone attempt','c'=>'(C) has__(C) anyone attempted','d'=>'(D) was__(D) attempted__(D) by__(D) anyone'], 'b'],
            ['10. Hot__(10) springs are formed__(10) when__(10) water _____ heated__(10) by__(10) underground__(10) volcanic activity.', ['a'=>'(A) is','b'=>'(B) was','c'=>'(C) it is','d'=>'(D) being'], 'a'],
            ['11. Quartz,ite mayite beiteite made up mostly _____ calcium__(11)ite carbonate.', ['a'=>'(A)ite in','b'=>'(B) of','c'=>'(C) from__(C) the','d'=>'(D) for'], 'b'],
            ['12. In the Arctic tundra, ice fog may form under clear skies in winter, _____ coastal fogs are common in summer.', ['a'=>'(A) because of','b'=>'(B) whereas','c'=>'(C) despite','d'=>'(D) that'], 'b'],
            ['13. The Milky Way galaxy, _____ Earth is a small part, is enormous.', ['a'=>'(A) which','b'=>'(B) of which','c'=>'(C) that','d'=>'(D) where'], 'b'],
            ['14. _____ the Civil War, the__(14) Southern__(14) states__(14)


 


 


were__(14)


readmitted__(14) to the Union.', ['a'=>'(A) Following','b'=>'(B) It__(B)


followed','c'=>'(C) That__(C) followed','d'=>'(D) To follow'], 'a'],
            ['15. J.K. Rowling wrote many amazing novels _____ famous worldwide.', ['a'=>'(A) that are became','b'=>'(B) that became','c'=>'(C) what became','d'=>'(D) what had become'], 'b'],
            // Part B: Written Expression - Error Identification (16-40)
            ['16. The museum has (A)been__(A) visited by (B)thousands__(B) of tourists (C)since__(C) it (D)has__(D)__(D) opened in 1990.', ['a'=>'(A) been','b'=>'(B) thousands','c'=>'(C) since','d'=>'(D) has opened'], 'd'],
            ['17. (A)Despite__(A) the heavy rain, the workers (B)continued__(B) to work (C)on__(C) the construction (D)sight__(D).', ['a'=>'(A) Despite','b'=>'(B) continued','c'=>'(C) on','d'=>'(D) sight'], 'd'],
            ['18. The professor asked the students (A)to__(A) submit (B)their__(B) research papers (C)not__(C) later (D)as__(D) Friday.', ['a'=>'(A) to','b'=>'(B) their','c'=>'(C) not','d'=>'(D) as'], 'd'],
            ['19. The (A)number__(A) of students (B)who__(B) (C)has__(C) enrolled in the program (D)has__(D) increased.', ['a'=>'(A) number','b'=>'(B) who','c'=>'(C) has','d'=>'(D) has increased'], 'c'],
            ['20. Neither the teacher (A)nor__(A) the students (B)was__(B) (C)aware__(C) of the (D)change__(D) in schedule.', ['a'=>'(A) nor','b'=>'(B) was','c'=>'(C) aware','d'=>'(D) change'], 'b'],
            ['21. The company (A)has__(A) been (B)manufacture__(B) electronic components (C)since__(C) the (D)early__(D) 1990s.', ['a'=>'(A) has','b'=>'(B) manufacture','c'=>'(C) since','d'=>'(D) early'], 'b'],
            ['22. (A)Among__(A) the oldest universities in the world (B)is__(B) the University of Bologna, (C)founding__(C) in (D)1088__(D).', ['a'=>'(A) Among','b'=>'(B) is','c'=>'(C) founding','d'=>'(D) 1088'], 'c'],
            ['23. The new highway (A)will__(A) (B)make__(B) it easier for (C)commuter__(C) to reach the (D)city__(D) center.', ['a'=>'(A) will','b'=>'(B) make','c'=>'(C) commuter','d'=>'(D) city'], 'c'],
            ['24. (A)Most__(A) of the (B)informations__(B) (C)provided__(C) in the report (D)was__(D) accurate.', ['a'=>'(A) Most','b'=>'(B) informations','c'=>'(C) provided','d'=>'(D) was'], 'b'],
            ['25. The athlete (A)which__(A) won the gold medal (B)has__(B) been training (C)for__(C) (D)over__(D) ten years.', ['a'=>'(A) which','b'=>'(B) has','c'=>'(C) for','d'=>'(D) over'], 'a'],
            ['26. It is (A)important__(A) that every student (B)attends__(B) the (C)orientation__(C) (D)session__(D).', ['a'=>'(A) important','b'=>'(B) attends','c'=>'(C) orientation','d'=>'(D) session'], 'b'],
            ['27. The children were (A)exciting__(A) about (B)going__(B) to the (C)amusement__(C) park (D)tomorrow__(D).', ['a'=>'(A) exciting','b'=>'(B) going','c'=>'(C) amusement','d'=>'(D) tomorrow'], 'a'],
            ['28. (A)Each__(A) of the students (B)are__(B) (C)required__(C) to bring (D)their__(D) own materials.', ['a'=>'(A) Each','b'=>'(B) are','c'=>'(C) required','d'=>'(D) their'], 'b'],
            ['29. The experiment was (A)conduct__(A) (B)under__(B) (C)controlled__(C) (D)conditions__(D).', ['a'=>'(A) conduct','b'=>'(B) under','c'=>'(C) controlled','d'=>'(D) conditions'], 'a'],
            ['30. (A)Although__(A) it rained (B)heavy__(B), the (C)outdoor__(C) event (D)continued__(D) as planned.', ['a'=>'(A) Although','b'=>'(B) heavy','c'=>'(C) outdoor','d'=>'(D) continued'], 'b'],
            ['31. The new regulation requires that all employees (A)must__(A) (B)complete__(B) (C)their__(C) training by the (D)end__(D) of the month.', ['a'=>'(A) must','b'=>'(B) complete','c'=>'(C) their','d'=>'(D) end'], 'a'],
            ['32. (A)Having__(A) (B)finished__(B) her homework, Sarah (C)decided__(C) taking a (D)short__(D) nap.', ['a'=>'(A) Having','b'=>'(B) finished','c'=>'(C) decided','d'=>'(D) short'], 'c'],
            ['33. The research (A)shows__(A) that (B)child__(B) who read regularly (C)perform__(C) (D)better__(D) in school.', ['a'=>'(A) shows','b'=>'(B) child','c'=>'(C) perform','d'=>'(D) better'], 'b'],
            ['34. The temperature in the desert can (A)rise__(A) (B)dramatic__(B) during the (C)daytime__(C) (D)hours__(D).', ['a'=>'(A) rise','b'=>'(B) dramatic','c'=>'(C) daytime','d'=>'(D) hours'], 'b'],
            ['35. By the time the ambulance (A)arrived__(A), the patient (B)has__(B) already (C)been__(C) (D)taken__(D) to the hospital.', ['a'=>'(A) arrived','b'=>'(B) has','c'=>'(C) been','d'=>'(D) taken'], 'b'],
            ['36. The city council (A)voted__(A) (B)unanimous__(B) to (C)approve__(C) the new (D)budget__(D).', ['a'=>'(A) voted','b'=>'(B) unanimous','c'=>'(C) approve','d'=>'(D) budget'], 'b'],
            ['37. (A)One__(A) of the (B)most__(B) popular tourist (C)attraction__(C) in Paris is the (D)Eiffel__(D) Tower.', ['a'=>'(A) One','b'=>'(B) most','c'=>'(C) attraction','d'=>'(D) Eiffel'], 'c'],
            ['38. The professor (A)emphasized__(A) the (B)important__(B) of (C)critical__(C) (D)thinking__(D) in academic work.', ['a'=>'(A) emphasized','b'=>'(B) important','c'=>'(C) critical','d'=>'(D) thinking'], 'b'],
            ['39. (A)Many__(A) students find it (B)difficulty__(B) to (C)balance__(C) their studies (D)with__(D) social activities.', ['a'=>'(A) Many','b'=>'(B) difficulty','c'=>'(C) balance','d'=>'(D) with'], 'b'],
            ['40. The (A)recently__(A) (B)published__(B) book has (C)receive__(C) (D)excellent__(D) reviews from critics.', ['a'=>'(A) recently','b'=>'(B) published','c'=>'(C) receive','d'=>'(D) excellent'], 'c'],
        ];

        foreach ($structureQuestions as $i => $q) {
            $choicesFormatted = $q[1];

            $question = Question::create([
                'id' => Str::uuid()->toString(),
                'section' => 'Structure',
                'skillCategory' => null,
                'content' => $q[0],
                'choices' => json_encode($choicesFormatted),
                'answerKey' => $q[2],
                'explanation' => '',
                'audioId' => null,
                'passageId' => null,
                'packageId' => null,
            ]);

            $shuffledEntries = [];
            foreach ($choicesFormatted as $k => $v) {
                $shuffledEntries[] = [$k, $v];
            }
            $allQuestions[] = [
                'id' => $question->id,
                'section' => 'Structure',
                'content' => $question->content,
                'choices' => $choicesFormatted,
                'answerKey' => $q[2],
                'shuffledEntries' => $shuffledEntries,
            ];
        }
        $this->command->info('✅ 40 soal Structure berhasil dibuat.');

        // ================================================================
        // SECTION 3: READING COMPREHENSION (50 soal)
        // ================================================================
        $readingQuestions = [
            // Passage 1: Photosynthesis (1-10)
            ['1. What is the main topic of the passage?', ['a'=>'a. The__(a) chemical__(a) composition__(a) of__(a) chlorophyll','b'=>'b. The__(b) process__(b) of__(b) photosynthesis','c'=>'c. Types of plants','d'=>'d. The__(d) discovery__(d) of__(d) oxygen'], 'b'],
            ['2. According to the passage, what do plants need for photosynthesis?', ['a'=>'a. Sunlight, water, and carbon dioxide','b'=>'b. Soil, water, and nitrogen','c'=>'c. Oxygen and glucose','d'=>'d. Minerals and vitamins'], 'a'],
            ['3. The word "convert" in line 3 is closest in meaning to', ['a'=>'a. destroy','b'=>'b. change','c'=>'c. produce','d'=>'d. collect'], 'b'],
            ['4. What is the primary product of photosynthesis?', ['a'=>'a. Carbon dioxide','b'=>'b. Water','c'=>'c. Glucose','d'=>'d. Chlorophyll'], 'c'],
            ['5. The word "essential" in line 7 could best be replaced by', ['a'=>'a. optional','b'=>'b. critical','c'=>'c. simple','d'=>'d. complex'], 'b'],
            ['6. According to the passage, chlorophyll is responsible for', ['a'=>'a. producing carbon dioxide','b'=>'b. absorbing sunlight','c'=>'c. storing water','d'=>'d. releasing nitrogen'], 'b'],
            ['7. It can be inferred from the passage that without photosynthesis', ['a'=>'a. plants would grow faster','b'=>'b. the atmosphere would have more oxygen','c'=>'c. life on Earth would not exist as we know it','d'=>'d. water would become scarce'], 'c'],
            ['8. The word "released" in line 12 is closest in meaning to', ['a'=>'a. absorbed','b'=>'b. captured','c'=>'c. set free','d'=>'d. contained'], 'c'],
            ['9. Where in the passage does the author describe the role of sunlight?', ['a'=>'a. Lines 1-3','b'=>'b. Lines 4-6','c'=>'c. Lines 8-10','d'=>'d. Lines 13-15'], 'a'],
            ['10. What does the author imply about photosynthesis?', ['a'=>'a. It only occurs in tropical regions.','b'=>'b. It is a relatively simple process.','c'=>'c. It is fundamental to the food chain.','d'=>'d. It requires very high temperatures.'], 'c'],
            // Passage 2: The Industrial Revolution (11-20)
            ['11. What is the passage mainly about?', ['a'=>'a. The history of cotton manufacturing','b'=>'b. The social and economic impact of the Industrial Revolution','c'=>'c. The invention of the steam engine','d'=>'d. Life in 18th-century England'], 'b'],
            ['12. The word "dramatically" in line 2 is closest in meaning to', ['a'=>'a. slowly','b'=>'b. slightly','c'=>'c. significantly','d'=>'d. temporarily'], 'c'],
            ['13. According to the passage, the Industrial Revolution began in', ['a'=>'a. France','b'=>'b. Germany','c'=>'c. The United States','d'=>'d. Great Britain'], 'd'],
            ['14. What effect did industrialization have on cities?', ['a'=>'a. Cities became smaller.','b'=>'b. Urban populations grew rapidly.','c'=>'c. People moved to rural areas.','d'=>'d. Cities became cleaner.'], 'b'],
            ['15. The word "subsequently" in line 8 is closest in meaning to', ['a'=>'a. previously','b'=>'b. simultaneously','c'=>'c. afterward','d'=>'d. suddenly'], 'c'],
            ['16. Which of the following is NOT mentioned as a result of industrialization?', ['a'=>'a. Increased pollution','b'=>'b. Child labor','c'=>'c. Rise of the middle class','d'=>'d. Improvement in healthcare'], 'd'],
            ['17. The word "harsh" in line 14 could best be replaced by', ['a'=>'a. fair','b'=>'b. pleasant','c'=>'c. severe','d'=>'d. unusual'], 'c'],
            ['18. It can be inferred from the passage that', ['a'=>'a. all workers benefited from industrialization','b'=>'b. the Industrial Revolution had both positive and negative effects','c'=>'c. factory work was easier than farm work','d'=>'d. only wealthy people supported industrialization'], 'b'],
            ['19. The author mentions child labor in order to', ['a'=>'a. praise the factories','b'=>'b. illustrate the negative aspects of industrialization','c'=>'c. compare it to modern times','d'=>'d. discuss education reform'], 'b'],
            ['20. The passage would most likely be found in', ['a'=>'a. a science textbook','b'=>'b. a history book','c'=>'c. a novel','d'=>'d. a mathematics journal'], 'b'],
            // Passage 3: The Solar System (21-30)
            ['21. What is the best title for this passage?', ['a'=>'a. The Sun and Its Energy','b'=>'b. An Overview of the Solar System','c'=>'c. How Planets Were Formed','d'=>'d. Space Exploration'], 'b'],
            ['22. The word "comprises" in line 1 is closest in meaning to', ['a'=>'a. excludes','b'=>'b. consists of','c'=>'c. resembles','d'=>'d. surrounds'], 'b'],
            ['23. According to the passage, how many planets are in the solar system?', ['a'=>'a. Seven','b'=>'b. Eight','c'=>'c. Nine','d'=>'d. Ten'], 'b'],
            ['24. The word "orbiting" in line 4 is closest in meaning to', ['a'=>'a. leaving','b'=>'b. circling','c'=>'c. entering','d'=>'d. observing'], 'b'],
            ['25. Which planet is described as the largest in the solar system?', ['a'=>'a. Saturn','b'=>'b. Neptune','c'=>'c. Jupiter','d'=>'d. Uranus'], 'c'],
            ['26. According to the passage, what separates the inner and outer planets?', ['a'=>'a. The Sun','b'=>'b. The asteroid belt','c'=>'c. The Moon','d'=>'d. A ring of dust'], 'b'],
            ['27. The word "terrestrial" in line 9 is closest in meaning to', ['a'=>'a. large','b'=>'b. gaseous','c'=>'c. Earth-like','d'=>'d. distant'], 'c'],
            ['28. It can be inferred from the passage that', ['a'=>'a. all planets have similar compositions','b'=>'b. the inner planets are rocky while the outer planets are gaseous','c'=>'c. only Earth has an atmosphere','d'=>'d. the solar system is shrinking'], 'b'],
            ['29. The author\'s purpose in writing this passage is to', ['a'=>'a. argue that Pluto should be a planet','b'=>'b. provide general information about the solar system','c'=>'c. explain how to become an astronaut','d'=>'d. compare the solar system to other galaxies'], 'b'],
            ['30. Where in the passage does the author discuss dwarf planets?', ['a'=>'a. Lines 1-3','b'=>'b. Lines 5-7','c'=>'c. Lines 10-12','d'=>'d. Lines 15-17'], 'd'],
            // Passage 4: Migration Patterns (31-40)
            ['31. The passage is primarily concerned with', ['a'=>'a. bird migration patterns','b'=>'b. animal migration in general','c'=>'c. the__(c) extinction of migratory species','d'=>'d. how birds navigate'], 'b'],
            ['32. The word "annually" in line 2 is closest in meaning to', ['a'=>'a. occasionally','b'=>'b. rarely','c'=>'c. every year','d'=>'d. continuously'], 'c'],
            ['33. According to the passage, what triggers migration in many animals?', ['a'=>'a. Changes in food supply','b'=>'b. Changes in daylight hours','c'=>'c. Changes in population density','d'=>'d. All of the above'], 'd'],
            ['34. The word "navigating" in line 7 is closest in meaning to', ['a'=>'a. swimming','b'=>'b. finding their way','c'=>'c. running','d'=>'d. feeding'], 'b'],
            ['35. Which of the following is NOT mentioned as a migratory animal?', ['a'=>'a. Wildebeest','b'=>'b. Monarch butterflies','c'=>'c. Elephants','d'=>'d. Salmon'], 'c'],
            ['36. The word "arduous" in line 12 is closest in meaning to', ['a'=>'a. enjoyable','b'=>'b. simple','c'=>'c. dangerous','d'=>'d. difficult'], 'd'],
            ['37. It can be inferred that migration is', ['a'=>'a. an instinctive behavior','b'=>'b. a learned behavior','c'=>'c. only found in birds','d'=>'d. decreasing over time'], 'a'],
            ['38. The passage states that some species migrate', ['a'=>'a. hundreds of kilometers','b'=>'b. thousands of kilometers','c'=>'c. across all continents','d'=>'d. only within their own country'], 'b'],
            ['39. The word "perilous" in line 18 could best be replaced by', ['a'=>'a. exciting','b'=>'b. routine','c'=>'c. risky','d'=>'d. predictable'], 'c'],
            ['40. What does the author suggest about climate change and migration?', ['a'=>'a. It has no effect on migration.','b'=>'b. It is disrupting traditional migration patterns.','c'=>'c. It is making migration easier.','d'=>'d. It only affects bird migration.'], 'b'],
            // Passage 5: Human Memory (41-50)
            ['41. What does the passage mainly discuss?', ['a'=>'a. Methods for improving memory','b'=>'b. Types and processes of human memory','c'=>'c. Memory loss in elderly people','d'=>'d. The__(d) history__(d) of__(d) memory__(d) research'], 'b'],
            ['42. The word "retain" in line 2 is closest in meaning to', ['a'=>'a. forget','b'=>'b. keep','c'=>'c. create','d'=>'d. change'], 'b'],
            ['43. According to the passage, how many main types of memory are there?', ['a'=>'a. Two','b'=>'b. Three','c'=>'c. Four','d'=>'d. Five'], 'b'],
            ['44. The word "retrieved" in line 8 is closest in meaning to', ['a'=>'a. stored','b'=>'b. recovered','c'=>'c. deleted','d'=>'d. replaced'], 'b'],
            ['45. Short-term memory can typically hold information for', ['a'=>'a. a few seconds','b'=>'b. about 20-30 seconds','c'=>'c. several hours','d'=>'d. indefinitely'], 'b'],
            ['46. The word "consolidation" in line 14 is closest in meaning to', ['a'=>'a. separation','b'=>'b. strengthening','c'=>'c. weakening','d'=>'d. deletion'], 'b'],
            ['47. According to the passage, which factor can affect memory?', ['a'=>'a. Sleep','b'=>'b. Stress','c'=>'c. Exercise','d'=>'d. All of the above'], 'd'],
            ['48. The word "decay" in line 19 is closest in meaning to', ['a'=>'a. improvement','b'=>'b. growth','c'=>'c. deterioration','d'=>'d. stability'], 'c'],
            ['49. It can be inferred from the passage that', ['a'=>'a. memory is a perfect recording system','b'=>'b. memory is a complex and imperfect process','c'=>'c. everyone has the same memory capacity','d'=>'d. memory cannot be improved'], 'b'],
            ['50. The passage would most likely appear in', ['a'=>'a. a psychology textbook','b'=>'b. a cooking book','c'=>'c. a travel guide','d'=>'d. a math textbook'], 'a'],
        ];

        foreach ($readingQuestions as $i => $q) {
            $choicesFormatted = $q[1];

            $question = Question::create([
                'id' => Str::uuid()->toString(),
                'section' => 'Reading',
                'skillCategory' => null,
                'content' => $q[0],
                'choices' => json_encode($choicesFormatted),
                'answerKey' => $q[2],
                'explanation' => '',
                'audioId' => null,
                'passageId' => null,
                'packageId' => null,
            ]);

            $shuffledEntries = [];
            foreach ($choicesFormatted as $k => $v) {
                $shuffledEntries[] = [$k, $v];
            }
            $allQuestions[] = [
                'id' => $question->id,
                'section' => 'Reading',
                'content' => $question->content,
                'choices' => $choicesFormatted,
                'answerKey' => $q[2],
                'shuffledEntries' => $shuffledEntries,
            ];
        }
        $this->command->info('✅ 50 soal Reading berhasil dibuat.');

        // ================================================================
        // PAKET FULL TEST
        // ================================================================
        TestPackage::create([
            'id' => Str::uuid()->toString(),
            'name' => 'TOEFL ITP Simulation - Full Test (Dummy)',
            'type' => 'Full Test',
            'questions' => $allQuestions,
            'durations' => [
                'listening' => 2100,   // 35 menit
                'structure' => 1500,   // 25 menit
                'reading'   => 3300,   // 55 menit
            ],
            'status' => 'published',
        ]);
        $this->command->info('✅ Paket "TOEFL ITP Simulation - Full Test (Dummy)" berhasil dibuat.');
        $this->command->info('📦 Total: 140 soal (50L + 40S + 50R) + 1 paket Full Test.');
    }
}
